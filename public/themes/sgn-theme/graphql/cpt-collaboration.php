<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$collaboration = new ObjectType([
    'name' => 'CollaborationFields',
    'fields' => [
        'image' => Type::string(),
        'title' => Type::string(),
        'content' => Type::string(),
        'pdf' => Type::string(),
        'website' => Type::string(),
        'contact_info' => new ObjectType([
            'name' => 'CollaborationContactInfo',
            'fields' => [
                'title' => Type::string(),
                'email' => Type::string(),
                'phone_number' => Type::string(),
            ],
        ]),
    ],
]);

add_action('graphql_register_types', function ($fields) use ($collaboration) {
    register_graphql_field('Collaboration', 'acf', [
        'type' => $collaboration,
        'resolve' => function ($post) {
            $collaborationFields = get_fields($post->ID);
            return $collaborationFields;
        },
    ]);
});