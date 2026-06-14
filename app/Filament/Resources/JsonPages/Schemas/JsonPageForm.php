<?php

namespace App\Filament\Resources\JsonPages\Schemas;

use App\Models\JsonPage;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Lang;

class JsonPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(Lang::get('admin.json_pages.labels.name'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('sections')
                    ->label(Lang::get('admin.json_pages.labels.sections'))
                    ->formatStateUsing(fn (?JsonPage $record) => $record ? json_encode($record->sections, JSON_PRETTY_PRINT) : '')
                    ->mutateDehydratedStateUsing(fn (?string $state) => json_decode($state ?? '[]', true))
                    ->json()
                    ->autosize()
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('translations')
                    ->label(Lang::get('admin.json_pages.labels.translations'))
                    ->formatStateUsing(fn (?JsonPage $record) => $record ? json_encode($record->translations, JSON_PRETTY_PRINT) : '')
                    ->mutateDehydratedStateUsing(fn (?string $state) => json_decode($state ?? '[]', true))
                    ->json()
                    ->autosize()
                    ->columnSpanFull(),
            ]);
    }
}
