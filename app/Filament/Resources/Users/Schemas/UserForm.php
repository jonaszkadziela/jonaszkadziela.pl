<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Lang;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(Lang::get('admin.users.labels.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(Lang::get('admin.users.labels.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('email_verified_at')
                    ->label(Lang::get('admin.users.labels.email_verified_at')),
                TextInput::make('password')
                    ->label(Lang::get('admin.users.labels.password'))
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->hiddenOn('edit'),
                Toggle::make('is_admin')
                    ->label(Lang::get('admin.users.labels.is_admin'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
