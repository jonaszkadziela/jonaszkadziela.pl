<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages\CreateMenu;
use App\Filament\Resources\MenuResource\Pages\EditMenu;
use App\Filament\Resources\MenuResource\Pages\ListMenus;
use App\Models\Menu;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bars-4';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(Lang::get('admin.menus.labels.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('route')
                    ->label(Lang::get('admin.menus.labels.route'))
                    ->required()
                    ->maxLength(255),
                Textarea::make('translations')
                    ->label(Lang::get('admin.menus.labels.translations'))
                    ->formatStateUsing(fn (?Menu $record) => $record ? json_encode($record->translations, JSON_PRETTY_PRINT) : '')
                    ->mutateDehydratedStateUsing(fn (?string $state) => json_decode($state ?? '[]', true))
                    ->json()
                    ->autosize()
                    ->columnSpanFull(),
                Toggle::make('is_only_in_footer')
                    ->label(Lang::get('admin.menus.labels.is_only_in_footer'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(Lang::get('admin.menus.labels.name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('route')
                    ->label(Lang::get('admin.menus.labels.route'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_only_in_footer')
                    ->label(Lang::get('admin.menus.labels.is_only_in_footer'))
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.menus.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.menus.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_only_in_footer')
                    ->label(Lang::get('admin.menus.labels.is_only_in_footer')),
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
            'index' => ListMenus::route('/'),
            'create' => CreateMenu::route('/create'),
            'edit' => EditMenu::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('admin.menus.model');
    }

    public static function getPluralModelLabel(): string
    {
        return Lang::get('admin.menus.models');
    }
}
