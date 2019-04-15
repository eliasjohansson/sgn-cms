<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

require template_path('graphql/image.php');

$home = new ObjectType([
    'name' => 'Home',
    'fields' => [
        'header' => new ObjectType([
            'name' => 'Header',
            'fields' => [
                'image' => $image,
                'title' => Type::string(),
            ],
        ]),
        'card1' => new ObjectType([
            'name' => 'Card 1',
            'fields' => [
                'image' => $image,
                'title' => Type::string(),
                'text' => Type::string(),
            ],
        ]),
        'quote' => Type::string(),
        'card2' => new ObjectType([
            'name' => 'Card 2',
            'fields' => [
                'image' => $image,
                'title' => Type::string(),
                'text' => Type::string(),
            ],
        ]),
    ],
]);

add_action('graphql_register_types', function ($fields) use ($home) {
    register_graphql_field('Page', 'home', [
        'type' => $home,
        'resolve' => function ($post) {
            $homeFields = get_fields($post->ID);
            return $homeFields;
        },
    ]);
});