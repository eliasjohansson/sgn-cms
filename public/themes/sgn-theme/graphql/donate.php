<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$donationAlt = new ObjectType([
    'name' => 'DonationAlternative',
    'fields' => [
        'name' => Type::string(),
        'value' => Type::string(),
    ],
]);

$donate = new ObjectType([
    'name' => 'DonateFields',
    'fields' => [
        'header' => $header,
        'collaborate_card' => new ObjectType([
            'name' => 'DonateCollabCard',
            'fields' => [
                'title' => Type::string(),
                'text' => Type::string(),
                'button_label' => Type::string(),
            ],
        ]),
        'donate_card' => new ObjectType([
            'name' => 'DonateCard',
            'fields' => [
                'title' => Type::string(),
                'text' => Type::string(),
                'donation_alternatives' => Type::listOf($donationAlt),
            ],
        ]),
        'member_banner' => new ObjectType([
            'name' => 'DonateMemberBanner',
            'fields' => [
                'title' => Type::string(),
                'button_label' => Type::string(),
            ],
        ]),
    ],
]);

add_action('graphql_register_types', function ($fields) use ($donate) {
    register_graphql_field('Page', 'donate', [
        'type' => $donate,
        'resolve' => function ($post) {
            $donateFields = get_fields($post->ID);
            return $donateFields;
        },
    ]);
});