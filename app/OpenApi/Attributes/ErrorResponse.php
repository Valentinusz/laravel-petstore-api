<?php

namespace App\Openapi\Attributes;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)] class ErrorResponse extends OA\Response
{
    public function __construct(
        int|string|null $response = null,
        ?string         $description = null,
        ?array          $headers = null,
        ?array          $links = null,
        // annotation
        ?array          $x = null,
        ?array          $attachables = null
    )
    {
        parent::__construct(
            response: $response,
            description: $description,
            headers: $headers,
            content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse"),
            links: $links,
            x: $x,
            attachables: $attachables
        );
    }
}
