<?php

namespace App\Filament\Resources\Tags\Schemas;

use App\Models\Tag;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Lang;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(Lang::get('admin.tags.labels.name'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('translations')
                    ->label(Lang::get('admin.tags.labels.translations'))
                    ->formatStateUsing(fn (?Tag $record) => $record ? json_encode($record->translations, JSON_PRETTY_PRINT) : '')
                    ->mutateDehydratedStateUsing(fn (?string $state) => json_decode($state ?? '[]', true))
                    ->json()
                    ->autosize()
                    ->columnSpanFull(),
            ]);
    }
}
