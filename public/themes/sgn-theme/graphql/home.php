<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

require template_path('graphql/image.php');

$homeType = new ObjectType([
    'name' => 'Homepage',
    'fields' => [
        'hero' => new ObjectType([
            'name' => 'Hero',
            'fields' => [
                'image' => $imageType,
                'title' => Type::string(),
            ],
        ]),
    ],
]);

add_action('graphql_page_fields', function ($fields) use ($homeType) {
    $fields['acf'] = [
        'type' => $homeType,
        'resolve' => function ($post) {
            $homeFields = get_fields($post->ID);
            return $homeFields;
        },
    ];

    return $fields;
});