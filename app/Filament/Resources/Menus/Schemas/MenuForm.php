<?php

namespace App\Filament\Resources\Menus\Schemas;

use App\Models\Menu;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Lang;

class MenuForm
{
    public static function configure(Schema $schema): Schema
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
}
