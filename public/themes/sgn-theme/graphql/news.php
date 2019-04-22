<?php

use GraphQL\Type\Definition\ObjectType;

$news = new ObjectType([
    'name' => 'NewsFields',
    'fields' => [
        'header' => $header,
    ],
]);

add_action('graphql_register_types', function ($fields) use ($news) {
    register_graphql_field('Page', 'news', [
        'type' => $news,
        'resolve' => function ($post) {
            $newsFields = get_fields($post->ID);
            return $newsFields;
        },
    ]);
});