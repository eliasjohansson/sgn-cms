<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$event = new ObjectType([
    'name' => 'EventFields',
    'fields' => [
        'date' => Type::string(),
        'facebook_event' => Type::string(),
        'image' => Type::string(),
    ],
]);

add_action('graphql_register_types', function ($fields) use ($event) {
    register_graphql_field('Event', 'acf', [
        'type' => $event,
        'resolve' => function ($post) {
            $eventFields = get_fields($post->ID);
            return $eventFields;
        },
    ]);
});