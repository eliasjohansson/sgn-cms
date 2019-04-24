<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$linkButton = new ObjectType([
    'name' => 'LinkButton',
    'fields' => [
        'label' => Type::string(),
        'link_type' => Type::string(),
        'external_link' => Type::string(),
        'internal_link' => Type::string(),
    ],
]);