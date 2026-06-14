<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Filament\Resources\PostResource\RelationManagers\FilesRelationManager;
use App\Filament\Resources\PostResource\RelationManagers\TagsRelationManager;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Lang;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(Lang::get('admin.posts.labels.user'))
                    ->relationship('user', 'name')
                    ->default(null),
                DateTimePicker::make('published_at')
                    ->label(Lang::get('admin.posts.labels.published_at')),
                TextInput::make('title')
                    ->label(Lang::get('admin.posts.labels.title'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label(Lang::get('admin.posts.labels.slug'))
                    ->required()
                    ->maxLength(255),
                Textarea::make('body')
                    ->label(Lang::get('admin.posts.labels.body'))
                    ->autosize()
                    ->columnSpanFull(),
                Textarea::make('translations')
                    ->label(Lang::get('admin.posts.labels.translations'))
                    ->formatStateUsing(fn (?Post $record) => $record ? json_encode($record->translations, JSON_PRETTY_PRINT) : '')
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
                TextColumn::make('user.name')
                    ->label(Lang::get('admin.posts.labels.user'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('slug')
                    ->label(Lang::get('admin.posts.labels.slug'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('title')
                    ->label(Lang::get('admin.posts.labels.title'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('body')
                    ->label(Lang::get('admin.posts.labels.body'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_at')
                    ->label(Lang::get('admin.posts.labels.published_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.posts.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.posts.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('published_at')
                    ->label(Lang::get('admin.posts.labels.published_at'))
                    ->options([
                        'only_published' => Lang::get('admin.posts.labels.only_published'),
                        'only_unpublished' => Lang::get('admin.posts.labels.only_unpublished'),
                    ])
                    ->modifyQueryUsing(fn (Builder $query, array $state) => match ($state['value']) {
                        'only_published' => $query->whereNotNull('published_at'),
                        'only_unpublished' => $query->whereNull('published_at'),
                        default => $query,
                    }),
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
            FilesRelationManager::class,
            TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('admin.posts.model');
    }

    public static function getPluralModelLabel(): string
    {
        return Lang::get('admin.posts.models');
    }
}
