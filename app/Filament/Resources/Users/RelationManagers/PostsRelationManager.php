<?php

namespace App\Filament\Resources\Users\RelationManagers;

use BackedEnum;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static string|BackedEnum|null $icon = 'heroicon-o-document-text';

    public function table(Table $table): Table
    {
        return $table
            ->heading(Lang::get('admin.posts.models'))
            ->modelLabel(Lang::get('admin.posts.model'))
            ->pluralModelLabel(Lang::get('admin.posts.models'))
            ->recordTitleAttribute('slug')
            ->columns([
                TextColumn::make('slug')
                    ->label(Lang::get('admin.posts.labels.slug'))
                    ->toggleable(),
                TextColumn::make('title')
                    ->label(Lang::get('admin.posts.labels.title'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('body')
                    ->label(Lang::get('admin.posts.labels.body'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_at')
                    ->label(Lang::get('admin.posts.labels.published_at'))
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.posts.labels.created_at'))
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.posts.labels.updated_at'))
                    ->dateTime()
                    ->toggleable(),
            ])
            ->headerActions([
                AssociateAction::make(),
            ])
            ->recordActions([
                DissociateAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                ]),
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return Lang::get('admin.posts.models');
    }
}
