<?php

namespace App\Filament\Shared\RelationManagers;

use BackedEnum;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class BaseTagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';

    protected static string|BackedEnum|null $icon = 'heroicon-o-tag';

    public function table(Table $table): Table
    {
        return $table
            ->heading(Lang::get('admin.tags.models'))
            ->modelLabel(Lang::get('admin.tags.model'))
            ->pluralModelLabel(Lang::get('admin.tags.models'))
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(Lang::get('admin.tags.labels.name'))
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.tags.labels.created_at'))
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.tags.labels.updated_at'))
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make('order')
                    ->label(Lang::get('admin.tags.labels.order'))
                    ->toggleable(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->schema(fn (AttachAction $action) => [
                        $action->getRecordSelect(),
                        TextInput::make('order')
                            ->label(Lang::get('admin.tags.labels.order'))
                            ->numeric()
                            ->required(),
                    ]),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return Lang::get('admin.tags.models');
    }
}
