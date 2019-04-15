<?php

use GraphQL\Type\Definition\ObjectType;

$branches = new ObjectType([
    'name' => 'BranchesFields',
    'fields' => [
        'header' => $header,
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