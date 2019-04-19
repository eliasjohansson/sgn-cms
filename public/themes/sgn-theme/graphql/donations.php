<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$newsPage = new ObjectType([
    'name' => 'DonationFields',
    'fields' => [
        'header' => $header,
    ],
]);

add_action('graphql_register_types', function ($fields) use ($Donations) {
    register_graphql_field('Page', 'donations', [
        'type' => $Donations,
        'resolve' => function ($post) {
            $DonationFields = get_fields($post->ID);
            return $DonationFields;
        },
    ]);
});