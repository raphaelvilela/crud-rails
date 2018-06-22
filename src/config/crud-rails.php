<?php

return [

    'forms' => [

        //View mestre dos formulários de CRUD.
        'page-layout' => 'admin.themes.01.layout',

        //View da paginação
        'pagination-layout' => 'vendor.pagination.bootstrap-4',

        'default_actions' => [
            [
                'method' => 'GET',
                'label' => 'Editar',
                'icon-class' => 'fa fa-edit',
                'btn-class' => 'btn btn-success btn-sm',
                'model-route' => 'edit'
            ],
            [
                'method' => 'DELETE',
                'label' => 'Apagar',
                'icon-class' => 'fa fa-times',
                'form-class' => 'd-inline-block',
                'btn-class' => 'btn btn-danger btn-sm',
                'model-route' => 'delete'
            ],
        ]
    ],

    'layout-utils' => [
        'hide-mobile-class' => 'hidden-xs'
    ],

    'photos' => [
    'filesystem' => [
        "name" => "photos",
        'base-url' => env('IMAGES_S3_URL', '/'),
    ]
]

];
