<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JsonPageResource\Pages;
use App\Models\JsonPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class JsonPageResource extends Resource
{
    protected static ?string $model = JsonPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(Lang::get('admin.json_pages.labels.name'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('sections')
                    ->label(Lang::get('admin.json_pages.labels.sections'))
                    ->formatStateUsing(fn (?JsonPage $record) => $record ? json_encode($record->sections, JSON_PRETTY_PRINT) : '')
                    ->mutateDehydratedStateUsing(fn (?string $state) => json_decode($state ?? '[]', true))
                    ->json()
                    ->autosize()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('translations')
                    ->label(Lang::get('admin.json_pages.labels.translations'))
                    ->formatStateUsing(fn (?JsonPage $record) => $record ? json_encode($record->translations, JSON_PRETTY_PRINT) : '')
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
                Tables\Columns\TextColumn::make('name')
                    ->label(Lang::get('admin.json_pages.labels.name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(Lang::get('admin.json_pages.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(Lang::get('admin.json_pages.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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
            'index' => Pages\ListJsonPages::route('/'),
            'create' => Pages\CreateJsonPage::route('/create'),
            'edit' => Pages\EditJsonPage::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('admin.json_pages.model');
    }

    public static function getPluralModelLabel(): string
    {
        return Lang::get('admin.json_pages.models');
    }
}
