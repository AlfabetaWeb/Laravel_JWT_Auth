<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{
    public function createTask(Request $request)
    {
        try {
            Log::info("Creating a task");

            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $validator->errors()
                    ],
                    400
                );
            };

            $title = $request->input('title');
            $userId = auth()->user()->id;

            $task = new Task();
            $task->title = $title;
            $task->user_id = $userId;

            $task->save();


            return response()->json(
                [
                    'success' => true,
                    'message' => "Task created"
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error("Error creating task: " . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => "Error creating tasks"
                ],
                500
            );
        }
    }
}
