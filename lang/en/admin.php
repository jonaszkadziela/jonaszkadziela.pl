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

    'change-language' => 'Change to Polish',
    'return-to-home-page' => 'Return to Home Page',

    'documents' => [
        'model' => 'Document',
        'models' => 'Documents',

        'labels' => [
            'body' => 'Body',
            'created_at' => 'Created',
            'issued_at' => 'Issued',
            'link' => 'Link',
            'slug' => 'Slug',
            'title' => 'Title',
            'translations' => 'Translations',
            'updated_at' => 'Updated',
        ],
    ],
    'feedbacks' => [
        'model' => 'Feedback',
        'models' => 'Feedbacks',

        'labels' => [
            'body' => 'Body',
            'created_at' => 'Created',
            'data' => 'Data',
            'type' => 'Type',
            'updated_at' => 'Updated',
        ],
        'types' => [
            'issue' => 'Issue',
            'praise' => 'Praise',
            'suggestion' => 'Suggestion',
        ],
    ],
    'files' => [
        'model' => 'File',
        'models' => 'Files',

        'disks' => [
            'local' => 'Local',
            'public' => 'Public',
            's3' => 'S3',
        ],
        'labels' => [
            'created_at' => 'Created',
            'document_upload' => 'Document upload',
            'file_role' => 'Role',
            'image_upload' => 'Image upload',
            'mime_type' => 'MIME type',
            'slug' => 'Slug',
            'storage_disk' => 'Storage disk',
            'storage_path' => 'Storage path',
            'updated_at' => 'Updated',
        ],
    ],
    'json_pages' => [
        'model' => 'JSON page',
        'models' => 'JSON pages',

        'labels' => [
            'created_at' => 'Created',
            'name' => 'Name',
            'sections' => 'Sections',
            'translations' => 'Translations',
            'updated_at' => 'Updated',
        ],
    ],
    'menus' => [
        'model' => 'Menu',
        'models' => 'Menus',

        'labels' => [
            'created_at' => 'Created',
            'is_only_in_footer' => 'Only in footer',
            'name' => 'Name',
            'route' => 'Route',
            'translations' => 'Translations',
            'updated_at' => 'Updated',
        ],
    ],
    'posts' => [
        'model' => 'Post',
        'models' => 'Posts',

        'labels' => [
            'body' => 'Body',
            'created_at' => 'Created',
            'only_published' => 'Only published',
            'only_unpublished' => 'Only unpublished',
            'published_at' => 'Published',
            'slug' => 'Slug',
            'title' => 'Title',
            'translations' => 'Translations',
            'updated_at' => 'Updated',
            'user' => 'Author',
        ],
    ],
    'projects' => [
        'model' => 'Project',
        'models' => 'Projects',

        'labels' => [
            'body' => 'Body',
            'created_at' => 'Created',
            'finished_at' => 'Finished',
            'is_pro_bono' => 'Pro bono',
            'link' => 'Link',
            'only_finished' => 'Only finished',
            'only_unfinished' => 'Only unfinished',
            'slug' => 'Slug',
            'started_at' => 'Started',
            'title' => 'Title',
            'translations' => 'Translations',
            'updated_at' => 'Updated',
        ],
    ],
    'socials' => [
        'model' => 'Social',
        'models' => 'Socials',

        'labels' => [
            'created_at' => 'Created',
            'icon' => 'Icon',
            'link' => 'Link',
            'title' => 'Title',
            'updated_at' => 'Updated',
        ],
    ],
    'tags' => [
        'model' => 'Tag',
        'models' => 'Tags',

        'labels' => [
            'created_at' => 'Created',
            'name' => 'Name',
            'order' => 'Order',
            'translations' => 'Translations',
            'updated_at' => 'Updated',
        ],
    ],
    'users' => [
        'model' => 'User',
        'models' => 'Users',

        'labels' => [
            'created_at' => 'Created',
            'email_verified_at' => 'Email verified',
            'email' => 'Email',
            'is_admin' => 'Admin',
            'name' => 'Name',
            'password' => 'Password',
            'updated_at' => 'Updated',
        ],
    ],

];
