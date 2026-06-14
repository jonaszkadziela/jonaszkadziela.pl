<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages\CreateDocument;
use App\Filament\Resources\DocumentResource\Pages\EditDocument;
use App\Filament\Resources\DocumentResource\Pages\ListDocuments;
use App\Filament\Resources\DocumentResource\RelationManagers\FilesRelationManager;
use App\Filament\Resources\DocumentResource\RelationManagers\TagsRelationManager;
use App\Models\Document;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-duplicate';

    public static function form(Schema $schema): Schema
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->label(Lang::get('admin.documents.labels.slug'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('title')
                    ->label(Lang::get('admin.documents.labels.title'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('body')
                    ->label(Lang::get('admin.documents.labels.body'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('link')
                    ->label(Lang::get('admin.documents.labels.link'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('issued_at')
                    ->label(Lang::get('admin.documents.labels.issued_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.documents.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.documents.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            FilesRelationManager::class,
            TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocuments::route('/'),
            'create' => CreateDocument::route('/create'),
            'edit' => EditDocument::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('admin.documents.model');
    }

    public static function getPluralModelLabel(): string
    {
        return Lang::get('admin.documents.models');
    }
}
