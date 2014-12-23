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

    ],

    'menu' => [

        'faq' => [
            'label'    => 'FAQs',
            'icon'     => 'extension://faq/extension.svg',
            'url'      => '@faq/faq',
            'active'   => '@faq/faq*',
            'access'   => 'faq: manage FAQs',
            'priority' => 0
        ]

    ],

    'permissions' => [

        'faq: manage FAQs' => [
            'title' => 'Manage FAQs'
        ]

    ]

];
