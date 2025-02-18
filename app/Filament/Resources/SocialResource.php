<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialResource\Pages;
use App\Models\Social;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class SocialResource extends Resource
{
    protected static ?string $model = Social::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(Lang::get('admin.socials.labels.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('icon')
                    ->label(Lang::get('admin.socials.labels.icon'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('link')
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
                Tables\Columns\TextColumn::make('title')
                    ->label(Lang::get('admin.socials.labels.title'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('link')
                    ->label(Lang::get('admin.socials.labels.link'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('icon')
                    ->label(Lang::get('admin.socials.labels.icon'))
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state) => new HtmlString(
                        '<div class="gap-2 inline-flex items-center"><i class="' . $state . '"></i>' . $state . '</div>',
                    ))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(Lang::get('admin.socials.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(Lang::get('admin.socials.labels.updated_at'))
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
            'index' => Pages\ListSocials::route('/'),
            'create' => Pages\CreateSocial::route('/create'),
            'edit' => Pages\EditSocial::route('/{record}/edit'),
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
