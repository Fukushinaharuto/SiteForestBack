<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $projectName = $request->input('name');
        $pages = $user->projects()->where('name', $projectName)->first()->pages()->pluck('name');

        return response()->json([
            'pages' => $pages
        ]);
    }
    public function store(PageRequest $request)
    {
        $user = Auth::user();
        $validatedData = $request->validated();
        $project = $user->projects()->where('name', $validatedData['name'])->first();
        try {
            $page = DB::transaction(function () use ($project, $validatedData) {
                return $project->pages()->create([
                    'name' => $validatedData['page'],
                ]);
            });

            return response()->json([
                "page" => $page->only(['name']),
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'プロジェクトの作成に失敗しました。',
                'error' => $error->getMessage(),
            ], 500);
        }
    }
}
