<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\RelationManagers\PostsRelationManager;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(Lang::get('admin.users.labels.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(Lang::get('admin.users.labels.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('email_verified_at')
                    ->label(Lang::get('admin.users.labels.email_verified_at')),
                TextInput::make('password')
                    ->label(Lang::get('admin.users.labels.password'))
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->hiddenOn('edit'),
                Toggle::make('is_admin')
                    ->label(Lang::get('admin.users.labels.is_admin'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(Lang::get('admin.users.labels.name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->label(Lang::get('admin.users.labels.email'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('email_verified_at')
                    ->label(Lang::get('admin.users.labels.email_verified_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_admin')
                    ->label(Lang::get('admin.users.labels.is_admin'))
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.users.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.users.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_admin')
                    ->label(Lang::get('admin.users.labels.is_admin')),
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

    public static function getRelations(): array
    {
        return [
            PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('admin.users.model');
    }

    public static function getPluralModelLabel(): string
    {
        return Lang::get('admin.users.models');
    }
}
