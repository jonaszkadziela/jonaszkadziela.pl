<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JsonPageResource\Pages\CreateJsonPage;
use App\Filament\Resources\JsonPageResource\Pages\EditJsonPage;
use App\Filament\Resources\JsonPageResource\Pages\ListJsonPages;
use App\Models\JsonPage;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class JsonPageResource extends Resource
{
    protected static ?string $model = JsonPage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-computer-desktop';

    public static function form(Schema $schema): Schema
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(Lang::get('admin.json_pages.labels.name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.json_pages.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.json_pages.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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

    public static function getPages(): array
    {
        return [
            'index' => ListJsonPages::route('/'),
            'create' => CreateJsonPage::route('/create'),
            'edit' => EditJsonPage::route('/{record}/edit'),
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
