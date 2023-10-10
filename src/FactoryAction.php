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
            throw new \Exception('You can\'t override the action. Sorry.');
        }

        $this->action = $this->createFactory();

        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-cog-8-tooth')
            ->color('warning')
            ->hidden(fn() => app()->isProduction())
            ->form([
                TextInput::make('quantity')
                    ->numeric()
                    ->rules('numeric|min:1')
                    ->default(1)
                    ->required(),
            ])
            ->requiresConfirmation()
            ->action('createFactory');
    }

    private function createFactory(): Closure
    {
        return function (array $data, $livewire) {
            $livewire->getModel()::factory($data['quantity'])->create();
        };
    }
}