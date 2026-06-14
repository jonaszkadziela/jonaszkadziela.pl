<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Lang;

class PostForm
{
    public static function configure(Schema $schema): Schema
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
}
