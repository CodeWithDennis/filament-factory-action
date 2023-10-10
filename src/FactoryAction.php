<?php

namespace CodeWithDennis\FactoryAction;

use Closure;
use Filament\Actions\Action;
use Filament\Actions\StaticAction;
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
            ->modalSubmitAction($this->myCustomAction())
            ->requiresConfirmation();
    }

    public function myCustomAction(): Action
    {
        $model = app($this->getModel());

        return Action::make('generate_factory')
            ->action(function (array $data) use ($model) {
                $model::factory($data['quantity'])->create();
            });
    }
}
