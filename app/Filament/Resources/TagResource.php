<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages\CreateTag;
use App\Filament\Resources\TagResource\Pages\EditTag;
use App\Filament\Resources\TagResource\Pages\ListTags;
use App\Models\Tag;
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

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    public static function form(Schema $schema): Schema
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(Lang::get('admin.tags.labels.name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.tags.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.tags.labels.updated_at'))
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
            'index' => ListTags::route('/'),
            'create' => CreateTag::route('/create'),
            'edit' => EditTag::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('admin.tags.model');
    }

    public static function getPluralModelLabel(): string
    {
        return Lang::get('admin.tags.models');
    }
}
