<?php

namespace CodeWithDennis\FactoryAction;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;

class FactoryAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'generate';
    }

    public function action(Closure|string|null $action): static
    {
        if ($action !== 'createFactory') {
            throw new \Exception('You\'re unable to override the action for this plugin');
        }

        $this->action = $this->createFactory();

        return $this;
    }

    public function form(array|Closure|null $form): static
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

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-cog-8-tooth')
            ->color('warning')
            ->hidden(fn() => app()->isProduction())
            ->form($this->getDefaultForm())
            ->modalIcon('heroicon-o-cog-8-tooth')
            ->color('success')
            ->modalWidth('md')
            ->modalAlignment('center')
            ->modalHeading(fn($livewire) => __('Generate ' . ucfirst($livewire->getTable()->getPluralModelLabel())))
            ->modalDescription(__('This action will create new records in the database. Are you sure you would like to proceed?'))
            ->modalFooterActionsAlignment('right')
            ->action('createFactory');
    }

    private function createFactory(): Closure
    {

        return function (array $data, $livewire) {
            $livewire->getModel()::factory($data['quantity'])->create();
        };
    }
}
