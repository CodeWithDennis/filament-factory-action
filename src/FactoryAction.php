<?php

namespace CodeWithDennis\FactoryAction;

use App\Models\Profile;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionMethod;

class FactoryAction extends Action
{
    protected array $relationships = [];

    public static function getDefaultName(): ?string
    {
        return 'generate';
    }

    public function action(Closure | string | null $action): static
    {
        if ($action !== 'createFactory') {
            throw new \Exception('You\'re unable to override the action for this plugin');
        }

        $this->action = $this->createFactory();

        return $this;
    }

    public function form(array | Closure | null $form): static
    {
        $this->form = $this->getDefaultForm();

        return $this;
    }

    protected function getDefaultForm(): array
    {
        // TODO: Allow to disable relationships
        $fields = [];

        foreach ($this->relationships as $relationship) {
            $relationshipName = (new ReflectionClass($relationship['name']))->getShortName();

            $fields[] = TextInput::make($relationship['name'])
                ->default(0)
                ->numeric()
                ->label(__($relationshipName))
                ->required();
        }

        return [
            TextInput::make('quantity')
                ->label(fn ($livewire) => (new ReflectionClass($livewire->getModel()))->getShortName())
                ->numeric()
                ->rules('numeric|min:1')
                ->default(1)
                ->columns()
                ->required(),

            Fieldset::make(__('Relationships'))
                ->schema($fields),
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $model = new Profile(); // TODO: Replace with actual model of the ResourcePage

        foreach ((new ReflectionClass($model))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (
                $method->class !== get_class($model) ||
                ! empty($method->getParameters()) ||
                $method->getName() === __FUNCTION__
            ) {
                continue;
            }

            $return = $method->invoke($model);

            if ($return instanceof Relation) {
                $relation = new ReflectionClass($return);

                if (in_array($relation->name, [HasMany::class, BelongsToMany::class])) {
                    $relatedModelName = (new ReflectionClass($return->getRelated()))->getName();

                    $this->relationships[$method->getName()] = [
                        'name' => $relatedModelName,
                        'relation' => $relation,
                    ];
                }
            }
        }

        $this->icon('heroicon-o-cog-8-tooth')
            ->color('warning')
            ->hidden(fn () => app()->isProduction())
            ->form($this->getDefaultForm())
            ->modalIcon('heroicon-o-cog-8-tooth')
            ->color('success')
            ->modalWidth('2xl')
            ->modalAlignment('center')
            ->modalHeading(fn ($livewire) => __('Generate'))
            ->modalDescription(__('This action will create new records in the database. Are you sure you would like to proceed?'))
            ->modalFooterActionsAlignment('right')
            ->closeModalByClickingAway(false)
            ->action('createFactory');
    }

    private function createFactory(): Closure
    {
        return function (array $data, $livewire) {
            $factory = $livewire->getModel()::factory($data['quantity']);
            unset($data['quantity']);

            foreach ($data as $key => $value) {
                $type = collect($this->relationships)->firstWhere('name', $key);
                if ($type && in_array($type['relation']->name, [HasMany::class, BelongsToMany::class])) {
                    $factory = $factory->has($key::factory()->count($value));
                }
            }

            return $factory->create();
        };
    }
}
