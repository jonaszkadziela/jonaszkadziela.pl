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

    'documents' => [
        'model' => 'Dokument',
        'models' => 'Dokumenty',

        'labels' => [
            'body' => 'Treść',
            'created_at' => 'Utworzono',
            'issued_at' => 'Wydano',
            'link' => 'Link',
            'slug' => 'Slug',
            'title' => 'Tytuł',
            'translations' => 'Tłumaczenie',
            'updated_at' => 'Zaktualizowano',
        ],
    ],
    'feedbacks' => [
        'model' => 'Opinia',
        'models' => 'Opinie',

        'labels' => [
            'body' => 'Treść',
            'created_at' => 'Utworzono',
            'data' => 'Dane',
            'type' => 'Typ',
            'updated_at' => 'Zaktualizowano',
        ],
        'types' => [
            'issue' => 'Problem',
            'praise' => 'Pochwała',
            'suggestion' => 'Sugestia',
        ],
    ],
    'files' => [
        'model' => 'Plik',
        'models' => 'Pliki',

        'disks' => [
            'local' => 'Lokalny',
            'public' => 'Publiczny',
            's3' => 'S3',
        ],
        'labels' => [
            'created_at' => 'Utworzono',
            'image_upload' => 'Prześlij obraz',
            'mime_type' => 'Typ MIME',
            'slug' => 'Slug',
            'storage_disk' => 'Dysk magazynujący',
            'storage_path' => 'Ścieżka do pliku',
            'updated_at' => 'Zaktualizowano',
        ],
    ],
    'json_pages' => [
        'model' => 'Strona JSON',
        'models' => 'Strony JSON',

        'labels' => [
            'created_at' => 'Utworzono',
            'name' => 'Nazwa',
            'sections' => 'Sekcje',
            'translations' => 'Tłumaczenie',
            'updated_at' => 'Zaktualizowano',
        ],
    ],
    'menus' => [
        'model' => 'Menu',
        'models' => 'Menu',

        'labels' => [
            'created_at' => 'Utworzono',
            'is_only_in_footer' => 'Tylko w stopce',
            'name' => 'Nazwa',
            'route' => 'Ścieżka',
            'translations' => 'Tłumaczenie',
            'updated_at' => 'Zaktualizowano',
        ],
    ],
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
    'tags' => [
        'model' => 'Tag',
        'models' => 'Tagi',

        'labels' => [
            'created_at' => 'Utworzono',
            'name' => 'Nazwa',
            'translations' => 'Tłumaczenie',
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
