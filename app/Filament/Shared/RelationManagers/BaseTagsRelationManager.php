<?php

namespace App\Filament\Shared\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class BaseTagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';

    protected static ?string $icon = 'heroicon-o-tag';

    public function table(Table $table): Table
    {
        return $table
            ->heading(Lang::get('admin.tags.models'))
            ->modelLabel(Lang::get('admin.tags.model'))
            ->pluralModelLabel(Lang::get('admin.tags.models'))
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(Lang::get('admin.tags.labels.name'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(Lang::get('admin.tags.labels.created_at'))
                    ->dateTime()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(Lang::get('admin.tags.labels.updated_at'))
                    ->dateTime()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('order')
                    ->label(Lang::get('admin.tags.labels.order'))
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action) => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('order')
                            ->label(Lang::get('admin.tags.labels.order'))
                            ->numeric()
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return Lang::get('admin.tags.models');
    }
}
