<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in the Admin panel.
    |
    */

    'change-language' => 'Zmień na angielski',

    'posts' => [
        'model' => 'Post',
        'models' => 'Posty',

        'labels' => [
            'body' => 'Treść',
            'created_at' => 'Utworzono',
            'only_published' => 'Tylko opublikowane',
            'only_unpublished' => 'Tylko nieopublikowane',
            'published_at' => 'Opublikowano',
            'slug' => 'Slug',
            'title' => 'Tytuł',
            'translations' => 'Tłumaczenie',
            'updated_at' => 'Zaktualizowano',
            'user' => 'Autor',
        ],
    ],
    'projects' => [
        'model' => 'Projekt',
        'models' => 'Projekty',

        'labels' => [
            'body' => 'Treść',
            'created_at' => 'Utworzono',
            'finished_at' => 'Zakończono',
            'is_pro_bono' => 'Pro bono',
            'link' => 'Link',
            'only_finished' => 'Tylko zakończone',
            'only_unfinished' => 'Tylko niezakończone',
            'slug' => 'Slug',
            'started_at' => 'Rozpoczęto',
            'title' => 'Tytuł',
            'translations' => 'Tłumaczenie',
            'updated_at' => 'Zaktualizowano',
        ],
    ],
    'socials' => [
        'model' => 'Medium społecznościowe',
        'models' => 'Media społecznościowe',

        'labels' => [
            'created_at' => 'Utworzono',
            'icon' => 'Ikona',
            'link' => 'Link',
            'title' => 'Tytuł',
            'updated_at' => 'Zaktualizowano',
        ],
    ],
    'users' => [
        'model' => 'Użytkownik',
        'models' => 'Użytkownicy',

        'labels' => [
            'created_at' => 'Utworzono',
            'email_verified_at' => 'Email zweryfikowany',
            'email' => 'Email',
            'is_admin' => 'Administrator',
            'name' => 'Nazwa',
            'password' => 'Hasło',
            'updated_at' => 'Zaktualizowano',
        ],
    ],

];
