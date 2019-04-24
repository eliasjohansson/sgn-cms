<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

require template_path('graphql/image.php');

$activity = new ObjectType([
    'name' => 'Activity',
    'fields' => [
        'title' => Type::string(),
        'description' => Type::string(),
        'date_time' => Type::string(),
        'image' => Type::string(),
    ],
]);

$branch = new ObjectType([
    'name' => 'BranchFields',
    'fields' => [
        'description' => Type::string(),
        'activities' => Type::listOf($activity),
        'events' => Type::string(),
    ],
]);

add_action('graphql_register_types', function ($fields) use ($branch) {
    register_graphql_field('Branch', 'acf', [
        'type' => $branch,
        'resolve' => function ($post) {
            $branchFields = get_fields($post->ID);
            if (!$branchFields['activities']) {
                $branchFields['activities'] = [];
            }
            $branchFields['events'] = json_encode($branchFields['events']);
            return $branchFields;
        },
    ]);
});