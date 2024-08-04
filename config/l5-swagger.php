<?php

return [

    'default' => 'default',

    'documentations' => [

        'default' => [
            'api' => [
                'title' => 'API Documentation',
            ],

            'routes' => [
                /*
                 * Route for accessing api documentation interface
                 */
                'api' => 'api/documentation',
            ],

            'paths' => [
                /*
                 * Absolute path to location where parsed swagger annotations will be stored
                 */
                'docs' => storage_path('api-docs'),

                /*
                 * URL path where parsed docs will be accessible
                 */
                'docs_json' => 'api-docs.json',

                /*
                 * Set this to annotate type
                 */
                'annotations' => base_path('core'),

                /*
                 * Absolute path to directory where to export views
                 */
                'views' => base_path('resources/views/vendor/l5-swagger'),

                /*
                 * Edit to set the swagger ui assets path
                 * This is useful if you want to have customizations
                 * for instance the swagger-ui-dist package
                 */
                'assets' => config_path('swagger-ui'),

                /*
                 * Absolute path to directory where vendor views will be exported
                 */
                'base' => env('L5_SWAGGER_BASE_PATH', null),

                /*
                 * Absolute path to generated documentation
                 */
                'swagger' => 'api-docs.json',
            ],
        ],

    ],

    'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', true),

    'swagger_version' => env('SWAGGER_VERSION', '3.0'),

    'constants' => [
        'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost'),
    ],

];
