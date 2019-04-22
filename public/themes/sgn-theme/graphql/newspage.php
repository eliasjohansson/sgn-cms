<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$newsPage = new ObjectType([
    'name' => 'NewsPageFields',
    'fields' => [
        'header' => $header,
    ],
]);

add_action('graphql_register_types', function ($fields) use ($newsPage) {
    register_graphql_field('Page', 'news', [
        'type' => $newsPage,
        'resolve' => function ($post) {
            $newsPageFields = get_fields($post->ID);
            return $newsPageFields;
        },
    ]);
});