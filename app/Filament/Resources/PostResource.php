<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Lang;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label(Lang::get('admin.posts.labels.user'))
                    ->relationship('user', 'name')
                    ->default(null),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label(Lang::get('admin.posts.labels.published_at')),
                Forms\Components\TextInput::make('title')
                    ->label(Lang::get('admin.posts.labels.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label(Lang::get('admin.posts.labels.slug'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('body')
                    ->label(Lang::get('admin.posts.labels.body'))
                    ->autosize()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('translations')
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label(Lang::get('admin.posts.labels.user'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(Lang::get('admin.posts.labels.slug'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(Lang::get('admin.posts.labels.title'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('body')
                    ->label(Lang::get('admin.posts.labels.body'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(Lang::get('admin.posts.labels.published_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(Lang::get('admin.posts.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(Lang::get('admin.posts.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('published_at')
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
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
