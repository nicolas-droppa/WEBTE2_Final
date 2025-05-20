<?php
namespace App\Http\Controllers\API;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0',
    title: 'M3th',
    description: 'math testing',
    contact: new OA\Contact(name: 'Swagger API Team'),
)]
#[OA\Server(
    url: 'https://node43.webte.fei.stuba.sk',
    description: 'API server',
)]
class OpenApiSpec
{
}