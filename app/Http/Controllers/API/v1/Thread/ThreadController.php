<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Repositories\ThreadRepository;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ThreadController extends Controller
{
    protected $thread;
    public function __construct()
    {
        $this->middleware(['user-block'])->except([
            'index',
            'show',
        ]);
        $this->thread=resolve(ThreadRepository::class);
    }

    public function index()
    {
        $threads = $this->thread->getAllAvailableThreads();

        return \response()->json($threads, Response::HTTP_OK);
    }

    public function show($slug)
    {
        $thread = $this->thread->getThreadBySlug($slug);

        return \response()->json($thread, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'channel_id' => 'required'
        ]);

        $this->thread->store($request);

        return \response()->json([
            'message' => 'thread created successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, Thread $thread)
    {

        $request->has('best_answer_id')
            ? $request->validate([
            'best_answer_id' => 'required'
        ])
            : $request->validate([
            'title' => 'required',
            'content' => 'required',
            'channel_id' => 'required'
        ]);

        if (Gate::forUser(auth()->user())->allows('user-thread', $thread)) {
            $this->thread->update($thread, $request);

            return \response()->json([
                'message' => 'thread updated successfully'
            ], Response::HTTP_OK);
        }

        return \response()->json([
            'message' => 'access denied'
        ], Response::HTTP_FORBIDDEN);
    }

    public function destroy(Thread $thread)
    {
        if (Gate::forUser(auth()->user())->allows('user-thread', $thread)) {
            $this->thread->destroy($thread);

            return \response()->json([
                'message' => 'thread deleted successfully'
            ], Response::HTTP_OK);
        }

        return \response()->json([
            'message' => 'access denied'
        ], Response::HTTP_FORBIDDEN);
    }
}
