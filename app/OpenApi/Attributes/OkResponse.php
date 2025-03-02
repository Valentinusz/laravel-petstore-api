<?php

namespace App\OpenApi\Attributes;

use OpenApi\Attributes as OA;
use OpenApi\Attributes\Attachable;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\XmlContent;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)] class OkResponse extends OA\Response
{
    public function __construct(
        string|object|null $ref = null,
        string $description = "Ok",
        ?array $headers = null,
        MediaType|JsonContent|XmlContent|Attachable|array|null $content = null,
        ?array $links = null,
        // annotation
        ?array $x = null,
        ?array $attachables = null
    )
    {
        parent::__construct(
            response: 200,
            description: $description,
            headers: $headers,
            content: $content,
            links: $links,
            x: $x,
            attachables: $attachables
        );
    }
}
