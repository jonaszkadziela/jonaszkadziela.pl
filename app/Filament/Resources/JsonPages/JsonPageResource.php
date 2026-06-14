<?php

namespace App\Filament\Resources\JsonPages;

use App\Filament\Resources\JsonPages\Pages\CreateJsonPage;
use App\Filament\Resources\JsonPages\Pages\EditJsonPage;
use App\Filament\Resources\JsonPages\Pages\ListJsonPages;
use App\Filament\Resources\JsonPages\Schemas\JsonPageForm;
use App\Filament\Resources\JsonPages\Tables\JsonPageTable;
use App\Models\JsonPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class JsonPageResource extends Resource
{
    protected static ?string $model = JsonPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;

    public static function form(Schema $schema): Schema
    {
        return JsonPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JsonPageTable::configure($table);
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
