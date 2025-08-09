<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\Action::make('change_password')
                    ->schema([

                        \Filament\Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->rule(\Illuminate\Validation\Rules\Password::default()),

                        \Filament\Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->same('password')
                            ->rule(\Illuminate\Validation\Rules\Password::default()),
                    ])
                    ->action(function (\App\Models\User $record, array $data) {
                        $record->update(['password' => bcrypt($data['password'])]);

                        \Filament\Notifications\Notification::make()
                            ->title('Senha atualizada com sucesso!')
                            ->success()
                            ->send();
                    })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
