<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$general = new ObjectType([
    'name' => 'GeneralInfoFields',
    'fields' => [
        'general_info' => new ObjectType([
            'name' => 'GeneralInfo',
            'fields' => [
                'title' => Type::string(),
            ],
        ]),
        'navbar' => new ObjectType([
            'name' => 'Navbar',
            'fields' => [
                'logo' => Type::string(),
                'links' => new ObjectType([
                    'name' => 'NavbarLinks',
                    'fields' => [
                        'home' => Type::string(),
                        'locations' => Type::string(),
                        'collaborations' => Type::string(),
                        'donate' => Type::string(),
                        'news' => Type::string(),
                        'membership' => Type::string(),
                    ],
                ]),
            ],
        ]),
        'footer' => new ObjectType([
            'name' => 'Footer',
            'fields' => [
                'logo' => Type::string(),
                'social_media' => new ObjectType([
                    'name' => 'SocialMedia',
                    'fields' => [
                        'facebook' => Type::string(),
                        'twitter' => Type::string(),
                        'instagram' => Type::string(),
                    ],
                ]),
                'contact_info' => new ObjectType([
                    'name' => 'FooterContactInfo',
                    'fields' => [
                        'email' => Type::string(),
                        'phone_number' => Type::string(),
                        'address' => Type::string(),
                    ],
                ]),
                'navigation' => new ObjectType([
                    'name' => 'FooterNavigation',
                    'fields' => [
                        'private_policy' => Type::string(),
                        'cookies' => Type::string(),
                        'login' => Type::string(),
                        'graphic_identity' => Type::string(),
                    ],
                ]),
                'copyright' => Type::string(),
            ],
        ]),
    ],
]);

add_action('graphql_register_types', function ($fields) use ($general) {
    register_graphql_field('generalInfoTranslation', 'acf', [
        'type' => $general,
        'resolve' => function ($post) {
            $generalFields = get_fields($post->ID);
            return $generalFields;
        },
    ]);
});