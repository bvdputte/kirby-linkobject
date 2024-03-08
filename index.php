<?php

include __DIR__ . '/src/Linkobject.php';

Kirby::plugin('bvdputte/kirby-linkobject', [
    'fields' => [
        'linkobject' => [
            'extends' => 'object',
        ]
    ],
    'blueprints' => [
        'fields/linkobject' => __DIR__ . '/blueprints/fields/linkobject.yml',
    ],
    'snippets' => [
        'linkobject/tag' => __DIR__ . '/snippets/tag.php',
    ],
    'fieldMethods' => [
        'toLinkObject' => function ($field) {
            return new bvdputte\Linkobject\Linkobject($field);
        }
    ]
]);
