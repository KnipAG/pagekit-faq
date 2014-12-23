<?php

return [

    'main' => 'Knip\\FAQ\\FaqExtension',

    'autoload' => [

        'Knip\\FAQ\\' => 'src'

    ],

    'resources' => [

        'export' => [
            'view' => 'views'
        ]

    ],

    'controllers' => 'src/Controller/*Controller.php',

    'settings' => [

        'system' => 'extension://faq/views/admin/settings.razr'

    ]

];
