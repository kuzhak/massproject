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

    public function index(Request $request)
    {
        $request->validate([
            'status' => 'string|in:' . ModelRequest::STATUS_ACTIVE . ',' . ModelRequest::STATUS_RESOLVED,
            'date_to' => 'date|date_format:Y-m-d',
            'date_from' => 'date|date_format:Y-m-d'
        ]);

        return $this->requestService->listRequest($request);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:3500'
        ]);

        return $this->requestService->createRequest($request->user(), $request->message);
    }

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
