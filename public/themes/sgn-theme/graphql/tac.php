<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$tac = new ObjectType([
    'name' => 'TermsConditions',
    'fields' => [
        'i_agree_to_the' => Type::string(),
        'terms_and_conditions' => Type::string(),
    ],
]);