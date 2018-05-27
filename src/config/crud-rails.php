<?php

return [

    'forms' => [

        //View mestre dos formulários de CRUD.
        'page-layout' => 'admin.themes.01.layout',

        //View da paginação
        'pagination-layout' => 'vendor.pagination.bootstrap-4',
    ],

    'photos' => [
        'filesystem' => [
            "name" => "photos",
            'base-url' => env('IMAGES_S3_URL', '/'),
        ]
    ]

];
