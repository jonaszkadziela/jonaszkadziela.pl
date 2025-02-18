<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('slug')
                    ->label(Lang::get('admin.documents.labels.slug'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->label(Lang::get('admin.documents.labels.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('link')
                    ->label(Lang::get('admin.documents.labels.link'))
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('issued_at')
                    ->label(Lang::get('admin.documents.labels.issued_at'))
                    ->required(),
                Forms\Components\Textarea::make('body')
                    ->label(Lang::get('admin.documents.labels.body'))
                    ->autosize()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('translations')
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
                Tables\Columns\TextColumn::make('slug')
                    ->label(Lang::get('admin.documents.labels.slug'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(Lang::get('admin.documents.labels.title'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('body')
                    ->label(Lang::get('admin.documents.labels.body'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('link')
                    ->label(Lang::get('admin.documents.labels.link'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('issued_at')
                    ->label(Lang::get('admin.documents.labels.issued_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(Lang::get('admin.documents.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(Lang::get('admin.documents.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
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
