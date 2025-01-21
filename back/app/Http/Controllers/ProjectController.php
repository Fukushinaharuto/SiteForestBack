<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projectList = $user->projects()->select('name', 'description', 'id')->get();
        return response()->json($projectList);
    }

    public function check(Request $request)
    {
        $user = Auth::user();
        $projectName = $request->input('name');
        $project = $user->projects()->where('name', $projectName)->first();
        $name = $user->projects()->pluck('name');

        if ($project) {
            $page = $project->pages()->pluck('name');
            return response()->json(['name' => $name, 'page' => $page]);
        } else {
            return response()->json(['name' => $name, 'page' => []], 404);
        }
    }


    public function store(ProjectRequest $request) 
    {
        $user = Auth::user();
        $validatedData = $request->validated();
    
        try {
            $project = DB::transaction(function () use ($user, $validatedData) {
                $project =  $user->projects()->create([
                    'name' => $validatedData['name'],
                    'description' => $validatedData['description'],
                ]);
                $project->pages()->create([
                    'name' => 'home',
                ]);
                return $project;
            });
            return response()->json(["project" => $project]);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'プロジェクトの作成に失敗しました。',
                'error' => $error->getMessage(),
            ], 500);
        }
    }
    

    public function update(ProjectRequest $request, $id) 
    {
        $user = Auth::user();
        $validatedData = $request->validated();
        try{
            $project = DB::transaction(function () use ($user, $validatedData, $id) {
                $project = $user->projects()->findOrFail($id);
                $project->update([
                    'name' => $validatedData['name'],
                    'description' => $validatedData['description'],
                ]);
                return;
            });
            return response()->json(['message' => 'プロジェクトの編集に成功しました。']);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'プロジェクトの編集に失敗しました。',
                'error' => $error->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'idArray' => 'required|array',
            'idArray.*' => 'integer|exists:projects,id',
        ]);
        $idArray = $validated['idArray'];
        try {
            DB::transaction(function () use ($idArray) {
                Project::whereIn("id", $idArray)->delete();
            });

            return response()->json(['message' => '削除に成功しました。']);
        } catch (\Exception $e) {
            return response()->json(['message' => '削除に失敗しました。'], 500);
        }
    }

}
