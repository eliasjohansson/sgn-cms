<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$newsPage = new ObjectType([
    'name' => 'MembershipFields',
    'fields' => [
        'header' => $header,
    ],
]);

add_action('graphql_register_types', function ($fields) use ($Membership) {
    register_graphql_field('Page', 'membership', [
        'type' => $Membership,
        'resolve' => function ($post) {
            $MembershipFields = get_fields($post->ID);
            return $MembershipFields;
        },
    ]);
});