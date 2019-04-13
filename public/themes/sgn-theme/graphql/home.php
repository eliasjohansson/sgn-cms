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
        'card1' => new ObjectType([
            'name' => 'Card 1',
            'fields' => [
                'image' => $imageType,
                'title' => Type::string(),
                'text' => Type::string(),
            ],
        ]),
        'quote' => Type::string(),
        'card2' => new ObjectType([
            'name' => 'Card 2',
            'fields' => [
                'image' => $imageType,
                'title' => Type::string(),
                'text' => Type::string(),
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