<?php

/**
 * The config file is optional. It accepts a return array with config options
 * Note: Never include more than one return statement, all options go within this single return array
 * In this example, we set debugging to true, so that errors are displayed onscreen.
 * This setting must be set to false in production.
 * All config options: https://getkirby.com/docs/reference/system/options
 */
return [
    'debug' => true, // turn off in production
    'panel' => [
        'slug' => 'panel', // change your panel url
        'menu' => [ // add a users section to the left menu
            'site',
            'system',
            'lab' => [
                'true'
            ],
            'users',
        ]
    ],

    'routes' => [
        [
            'pattern' => 'feed',
            'action'  => function() {
                $data = page('feed')->render(['template' => 'feed.json']);
                $response = new Kirby\Http\Response($data, 'application/feed+json');
                return $response;
            }
        ],
    ],
];
