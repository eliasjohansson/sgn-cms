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
        'contact_info' => new ObjectType([
            'name' => 'BranchContactInfo',
            'fields' => [
                'address_label' => Type::string(),
                'address' => Type::string(),
                'email_label' => Type::string(),
                'email' => Type::string(),
                'phone_number_label' => Type::string(),
                'phone_number' => Type::string(),
                'social_media_label' => Type::string(),
                'social_media' => new ObjectType([
                    'name' => 'BranchSocialMedia',
                    'fields' => [
                        'facebook' => Type::string(),
                        'twitter' => Type::string(),
                        'instagram' => Type::string(),
                    ],
                ]),
            ],
        ]),
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
