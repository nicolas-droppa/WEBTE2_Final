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

 /**
 * @OA\Schema(
 *   schema="User",
 *   type="object",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="name", type="string"),
 *   @OA\Property(property="email", type="string"),
 *   @OA\Property(property="email_verified_at", type="string", nullable=true, format="date-time"),
 *   @OA\Property(property="created_at", type="string", format="date-time"),
 *   @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *   schema="Test",
 *   type="object",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="title", type="string"),
 *   @OA\Property(property="questions", type="array", @OA\Items(ref="#/components/schemas/Question"))
 * )
 *
 * @OA\Schema(
 *   schema="Question",
 *   type="object",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="assignment_sk", type="string"),
 *   @OA\Property(property="assignment_en", type="string"),
 *   @OA\Property(property="isMultiChoice", type="boolean"),
 *   @OA\Property(property="answers", type="array", @OA\Items(ref="#/components/schemas/Answer")),
 *   @OA\Property(property="tags", type="array", @OA\Items(ref="#/components/schemas/Tag"))
 * )
 *
 * @OA\Schema(
 *   schema="Answer",
 *   type="object",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="question_id", type="integer"),
 *   @OA\Property(property="answer_sk", type="string"),
 *   @OA\Property(property="answer_en", type="string"),
 *   @OA\Property(property="isCorrect", type="boolean")
 * )
 *
 * @OA\Schema(
 *   schema="Tag",
 *   type="object",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="name_sk", type="string"),
 *   @OA\Property(property="name_en", type="string")
 * )
 *
 * @OA\Schema(
 *   schema="HistoryTest",
 *   type="object",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="user_id", type="integer"),
 *   @OA\Property(property="test_id", type="integer"),
 *   @OA\Property(property="score", type="integer"),
 *   @OA\Property(property="city", type="string"),
 *   @OA\Property(property="state", type="string"),
 *   @OA\Property(property="created_at", type="string", format="date-time"),
 *   @OA\Property(property="updated_at", type="string", format="date-time"),
 *   @OA\Property(property="questions", type="array", @OA\Items(ref="#/components/schemas/Question"))
 * )
 *
 * @OA\Schema(
 *   schema="HistoryTestQuestion",
 *   type="object",
 *   @OA\Property(property="history_test_id", type="integer"),
 *   @OA\Property(property="question_id", type="integer"),
 *   @OA\Property(property="answer_id", type="integer", nullable=true),
 *   @OA\Property(property="written_answer", type="string", nullable=true),
 *   @OA\Property(property="time", type="number", format="float", nullable=true)
 * )
 */

class OpenApiSpec
{
}