<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialResource\Pages\CreateSocial;
use App\Filament\Resources\SocialResource\Pages\EditSocial;
use App\Filament\Resources\SocialResource\Pages\ListSocials;
use App\Models\Social;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class SocialResource extends Resource
{
    protected static ?string $model = Social::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-link';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(Lang::get('admin.socials.labels.title'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('icon')
                    ->label(Lang::get('admin.socials.labels.icon'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('link')
                    ->label(Lang::get('admin.socials.labels.link'))
                    ->required()
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(Lang::get('admin.socials.labels.title'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('link')
                    ->label(Lang::get('admin.socials.labels.link'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('icon')
                    ->label(Lang::get('admin.socials.labels.icon'))
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state) => new HtmlString(
                        '<div class="gap-2 inline-flex items-center"><i class="' . $state . '"></i>' . $state . '</div>',
                    ))
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.socials.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.socials.labels.updated_at'))
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

    public static function getPages(): array
    {
        return [
            'index' => ListSocials::route('/'),
            'create' => CreateSocial::route('/create'),
            'edit' => EditSocial::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('admin.socials.model');
    }

    public static function getPluralModelLabel(): string
    {
        return Lang::get('admin.socials.models');
    }
}
