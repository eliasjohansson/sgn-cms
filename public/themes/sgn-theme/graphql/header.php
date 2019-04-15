<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$header = new ObjectType([
    'name' => 'Header',
    'fields' => [
        'title' => Type::string(),
        'text' => Type::string(),
        'image' => Type::string(),
        'cta' => $cta,
    ],
]);