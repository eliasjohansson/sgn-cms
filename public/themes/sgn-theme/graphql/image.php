<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$imageType = new ObjectType([
    'name' => 'Image',
    'fields' => [
        'id' => Type::int(),
        "title" => Type::string(),
        "filename" => Type::string(),
        "filesize" => Type::int(),
        "url" => Type::string(),
        "link" => Type::string(),
        "alt" => Type::string(),
        "author" => Type::int(),
        "description" => Type::string(),
        "caption" => Type::string(),
        "name" => Type::string(),
        "status" => Type::string(),
        "uploaded_to" => Type::int(),
        "date" => Type::string(),
        "modified" => Type::string(),
        "menu_order" => Type::int(),
        "mime_type" => Type::string(),
        "type" => Type::string(),
        "subtype" => Type::string(),
        "icon" => Type::string(),
        "width" => Type::int(),
        "height" => Type::int(),
        "sizes" => new ObjectType([
            'name' => 'Sizes',
            'fields' => [
                "thumbnail" => Type::string(),
                "thumbnail-width" => Type::int(),
                "thumbnail-height" => Type::int(),
                "medium" => Type::string(),
                "medium-width" => Type::int(),
                "medium-height" => Type::int(),
                "medium_large" => Type::string(),
                "medium_large-width" => Type::int(),
                "medium_large-height" => Type::int(),
                "large" => Type::string(),
                "large-width" => Type::int(),
                "large-height" => Type::int(),
            ],
        ]),
    ],
]);