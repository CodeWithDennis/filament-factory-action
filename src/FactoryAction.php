<?php

namespace CodeWithDennis\FactoryAction;

use App\Models\Profile;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;

//use Filament\Tables\Actions\Action;

class FactoryAction extends Action
{
    protected ?string $name = 'generate';

    public function action(Closure | string | null $action): static
    {
        if (! is_null($action)) {
            throw new \Exception('You can\'t override the action. Sorry.');
        }
        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-cog-8-tooth')
            ->color('warning')
            ->hidden(fn () => app()->isProduction())
            ->form([
                TextInput::make('quantity')
                    ->numeric()
                    ->rules('numeric|min:1')
                    ->default(1)
                    ->required(),
            ])
            ->action(null)
            ->modalSubmitAction(fn($livewire) => $this->myCustomAction($livewire->getModel()))
            ->requiresConfirmation();
    }

    public function myCustomAction(string $model)
    {
        // TODO: Get the form data and replace '5' with the quantity value
        $model::factory(5)->create();
    }
}
