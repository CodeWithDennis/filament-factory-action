<?php

namespace CodeWithDennis\FactoryAction;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
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
                ->label(fn ($livewire) => __('Amount of ' . $livewire->getTable()->getPluralModelLabel()))
                ->numeric()
                ->rules('numeric|min:1')
                ->default(1)
                ->columns()
                ->required(),

            TextInput::make('relational_quantity')
                ->label(fn ($livewire) => __('Amount of relational models'))
                ->numeric()
                ->visible(fn () => count($this->belongsToManyRelations) || count($this->hasManyRelations))
                ->rules('numeric|min:1')
                ->default(1)
                ->columns()
                ->required(),

            Select::make('attach')
                ->options(fn () => collect($this->belongsToManyRelations)
                    ->mapWithKeys(fn ($value) => [$value => __(class_basename($value))]))
                ->visible(fn () => count($this->belongsToManyRelations))
                ->native(false)
                ->multiple(),

            Select::make('create')
                ->options(fn () => collect($this->hasManyRelations)
                    ->mapWithKeys(fn ($value) => [$value => __(class_basename($value))]))
                ->visible(fn () => count($this->hasManyRelations))
                ->native(false)
                ->multiple(),
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

            foreach ($this->hasManyRelations as $hasManyRelation) {
                if (isset($data['create']) && in_array($hasManyRelation, $data['create'])) {
                    $factory = $factory->has($hasManyRelation::factory()->count($data['relational_quantity']));
                }
            }

            foreach ($this->belongsToManyRelations as $belongsToManyRelation) {
                if (isset($data['attach']) && in_array($belongsToManyRelation, $data['attach'])) {
                    $models = $belongsToManyRelation::inRandomOrder()->limit($data['relational_quantity'])->get();
                    $factory = $factory->hasAttached($models);
                }
            }

            return $factory->create();
        };
    }
}
