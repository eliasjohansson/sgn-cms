<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$branches = new ObjectType([
    'name' => 'BranchesFields',
    'fields' => [
        'header' => $header,
        'activities_title' => Type::string(),
        'events_title' => Type::string(),
    ],
]);

add_action('graphql_register_types', function ($fields) use ($branches) {
    register_graphql_field('Page', 'branches', [
        'type' => $branches,
        'resolve' => function ($post) {
            $branchesFields = get_fields($post->ID);
            return $branchesFields;
        },
    ]);
});