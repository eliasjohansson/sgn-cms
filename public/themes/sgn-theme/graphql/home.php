<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$card = new ObjectType([
    'name' => 'Card',
    'fields' => [
        'image' => Type::string(),
        'title' => Type::string(),
        'text' => Type::string(),
    ],
]);

$visionsSection = new ObjectType([
    'name' => 'VisionsSection',
    'fields' => [
        'title' => Type::string(),
        'list' => Type::listOf(new ObjectType([
            'name' => 'Vision',
            'fields' => [
                'image' => Type::string(),
                'text' => Type::string(),
            ],
        ])),
    ],
]);

$awardsSection = new ObjectType([
    'name' => 'AwardsSection',
    'fields' => [
        'title' => Type::string(),
        'list' => Type::listOf(new ObjectType([
            'name' => 'Visions Section',
            'fields' => [
                'image' => Type::string(),
                'description' => Type::string(),
                'link' => Type::string(),
            ],
        ])),
    ],
]);

$newsInfoBox = new ObjectType([
    'name' => 'HomeNewsInfoBox',
    'fields' => [
        'title' => Type::string(),
        'text' => Type::string(),
        'button_label' => Type::string(),
    ],
]);

$partners = new ObjectType([
    'name' => 'Partners',
    'fields' => [
        'title' => Type::string(),
        'list' => Type::listOf(new ObjectType([
            'name' => 'Partner',
            'fields' => [
                'logo' => Type::string(),
                'name' => Type::string(),
                'link' => Type::string(),
            ],
        ])),
    ],
]);

$formField = new ObjectType([
    'name' => 'FormField',
    'fields' => [
        'label' => Type::string(),
        'instructions' => Type::string(),
    ],
]);

$contact = new ObjectType([
    'name' => 'ContactSection',
    'fields' => [
        'title' => Type::string(),
        'text' => Type::string(),
        'form' => new ObjectType([
            'name' => 'Contact Form',
            'fields' => [
                'name' => $formField,
                'email' => $formField,
                'subject' => $formField,
                'message' => $formField,
                'tac_label' => Type::string(),
                'button_label' => Type::string(),
            ],
        ]),
    ],
]);

$infoCard = new ObjectType([
    'name' => 'HomeInfoCard',
    'fields' => [
        'image' => Type::string(),
        'title' => Type::string(),
        'text' => Type::string(),
        'link_button' => $linkButton,
    ],
]);

$home = new ObjectType([
    'name' => 'HomeFields',
    'fields' => [
        'header' => $header,
        'card1' => $card,
        'quote' => Type::string(),
        'card2' => $card,
        'green_banner_1' => $banner,
        'green_banner_2' => $banner,
        'info_cards' => new ObjectType([
            'name' => 'HomeInfoCards',
            'fields' => [
                'card_1' => $infoCard,
                'card_2' => $infoCard,
            ],
        ]),
        'visions' => $visionsSection,
        'awards' => $awardsSection,
        'news_info_box' => $newsInfoBox,
        'partners' => $partners,
        'contact' => $contact,
    ],
]);

add_action('graphql_register_types', function ($fields) use ($home) {
    register_graphql_field('Page', 'home', [
        'type' => $home,
        'resolve' => function ($post) {
            $homeFields = get_fields($post->ID);
            return $homeFields;
        },
    ]);
});