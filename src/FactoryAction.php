<?php

namespace CodeWithDennis\FactoryAction;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;

class FactoryAction extends Action
{
    protected array $hasManyRelations = [];

    protected array $belongsToManyRelations = [];

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
        return [
            TextInput::make('quantity')
                ->numeric()
                ->rules('numeric|min:1')
                ->default(1)
                ->required(),
        ];
    }

    public function hasMany(array $relations): static
    {
        $this->hasManyRelations = $relations;

        return $this;
    }

    public function belongsToMany(array $relations): static
    {
        $this->belongsToManyRelations = $relations;

        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-cog-8-tooth')
            ->color('warning')
            ->hidden(fn () => app()->isProduction())
            ->form($this->getDefaultForm())
            ->modalIcon('heroicon-o-cog-8-tooth')
            ->color('success')
            ->modalWidth('md')
            ->modalAlignment('center')
            ->modalHeading(fn ($livewire) => __('Generate ' . ucfirst($livewire->getTable()->getPluralModelLabel())))
            ->modalDescription(__('This action will create new records in the database. Are you sure you would like to proceed?'))
            ->modalFooterActionsAlignment('right')
            ->action('createFactory');
    }

    private function createFactory(): Closure
    {
        return function (array $data, $livewire) {
            $factory = $livewire->getModel()::factory($data['quantity']);

            foreach ($this->hasManyRelations as $hasManyRelation => $quantity) {
                $factory = $factory->has($hasManyRelation::factory()->count($quantity));
            }

            foreach ($this->belongsToManyRelations as $belongsToManyRelation => $quantity) {
                $models = $belongsToManyRelation::inRandomOrder()->limit($quantity)->get();
                $factory = $factory->hasAttached($models);
            }

            return $factory->create();
        };
    }
}
