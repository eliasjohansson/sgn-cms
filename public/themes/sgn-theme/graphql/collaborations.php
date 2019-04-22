<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$collaborations = new ObjectType([
    'name' => 'CollaborationsFields',
    'fields' => [
        'header' => $header,
        'projects_title' => Type::string(),
        'green_banner' => $banner,
    ],
]);

add_action('graphql_register_types', function ($fields) use ($collaborations) {
    register_graphql_field('Page', 'collaborations', [
        'type' => $collaborations,
        'resolve' => function ($post) {
            $collaborationsFields = get_fields($post->ID);
            return $collaborationsFields;
        },
    ]);
});