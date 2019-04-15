<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$cta = new ObjectType([
    'name' => 'CTA',
    'fields' => [
        'label' => Type::string(),
        'link' => Type::string(),
    ],
]);