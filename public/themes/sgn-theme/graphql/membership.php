<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$form = new ObjectType([
    'name' => 'MembershipForm',
    'fields' => [
        'title' => Type::string(),
        'labels' => new ObjectType([
            'name' => 'MembershipFormLabels',
            'fields' => [
                'first_name' => Type::string(),
                'last_name' => Type::string(),
                'personal_number' => Type::string(),
                'birth_date' => Type::string(),
                'lma' => Type::string(),
                'address' => Type::string(),
                'zipcode' => Type::string(),
                'city' => Type::string(),
                'nationality' => Type::string(),
                'in_sweden_from' => Type::string(),
                'email' => Type::string(),
                'mobile_number' => Type::string(),
                'education' => Type::string(),
                'profession' => Type::string(),
                'mother_language' => Type::string(),
                'add_another_language' => Type::string(),
            ],
        ]),
        'terms_and_condition' => $tac,
        'sign_up_button' => Type::string(),
    ],
]);

$membership = new ObjectType([
    'name' => 'MembershipFields',
    'fields' => [
        'header' => $header,
        'form' => $form,
    ],
]);

add_action('graphql_register_types', function ($fields) use ($membership) {
    register_graphql_field('Page', 'membership', [
        'type' => $membership,
        'resolve' => function ($post) {
            $membershipFields = get_fields($post->ID);
            return $membershipFields;
        },
    ]);
});