<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$button = new ObjectType([
    'name' => 'Button',
    'fields' => [
        'label' => Type::string(),
        'link' => Type::string(),
    ],
]);