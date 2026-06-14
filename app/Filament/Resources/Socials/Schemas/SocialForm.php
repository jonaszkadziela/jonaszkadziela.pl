<?php

namespace App\Filament\Resources\Socials\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Lang;

class SocialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(Lang::get('admin.socials.labels.title'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('icon')
                    ->label(Lang::get('admin.socials.labels.icon'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('link')
                    ->label(Lang::get('admin.socials.labels.link'))
                    ->required()
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }
}
