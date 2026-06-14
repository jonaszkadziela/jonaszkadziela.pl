<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Document;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Lang;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->label(Lang::get('admin.documents.labels.slug'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('title')
                    ->label(Lang::get('admin.documents.labels.title'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('link')
                    ->label(Lang::get('admin.documents.labels.link'))
                    ->maxLength(255)
                    ->default(null),
                DateTimePicker::make('issued_at')
                    ->label(Lang::get('admin.documents.labels.issued_at'))
                    ->required(),
                Textarea::make('body')
                    ->label(Lang::get('admin.documents.labels.body'))
                    ->autosize()
                    ->columnSpanFull(),
                Textarea::make('translations')
                    ->label(Lang::get('admin.documents.labels.translations'))
                    ->formatStateUsing(fn (?Document $record) => $record ? json_encode($record->translations, JSON_PRETTY_PRINT) : '')
                    ->mutateDehydratedStateUsing(fn (?string $state) => json_decode($state ?? '[]', true))
                    ->json()
                    ->autosize()
                    ->columnSpanFull(),
            ]);
    }
}
