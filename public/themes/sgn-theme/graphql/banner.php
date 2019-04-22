<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$banner = new ObjectType([
    'name' => 'Banner',
    'fields' => [
        'title' => Type::string(),
        'text' => Type::string(),
        'button' => $button,
    ],
]);