<?php

namespace App\Http\Controllers;

use App\Services\EmailServiceInterface;
use App\Services\RequestServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Request as ModelRequest;

class RequestController extends Controller
{
    public function __construct(
        protected RequestServiceInterface $requestService,
        protected EmailServiceInterface $emailService,
    )
    {
    }

    /**
     * @OA\Get(
     *     path="/api/requests",
     *     summary="Get requests",
     *     description="Get requests with optional parameters",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="The status of the request",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"active", "resolved"}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="date_from",
     *         in="query",
     *         description="The start date",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="date",
     *             example="2022-01-01"
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="date_to",
     *          in="query",
     *          description="The end date",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date",
     *              example="2023-01-01"
     *          )
     *      ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *     )
     * )
     */
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'string|in:' . ModelRequest::STATUS_ACTIVE . ',' . ModelRequest::STATUS_RESOLVED,
            'date_to' => 'date|date_format:Y-m-d',
            'date_from' => 'date|date_format:Y-m-d'
        ]);

        return $this->requestService->listRequest($request);
    }

    /**
     * @OA\Post(
     *     path="/api/requests",
     *     summary="Create request",
     *     description="Create request with optional parameters",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="message",
     *         in="query",
     *         description="The message of the request",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:3500'
        ]);

        return $this->requestService->createRequest($request->user(), $request->message);
    }

    /**
     * @OA\Put(
     *     path="/api/requests/{id}",
     *     summary="Update request comment",
     *     description="Update request comment",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the request",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="comment",
     *          in="query",
     *          description="The comment of the request",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response="200",
     *         description="Request comment updated successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Request not found"
     *     )
     * )
     */
    public function update(int $id, Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:3500'
        ]);

        try {
            $answerRequest = $this->requestService->answerRequest($id, $request->comment);
            $this->emailService->send($answerRequest->email, "Response to application", $answerRequest->comment);
            return $answerRequest;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Request not found'], 404);
        }
    }
}
