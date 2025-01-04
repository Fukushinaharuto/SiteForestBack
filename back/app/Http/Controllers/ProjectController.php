<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectNameRequest;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $name = $user->projects()->pluck('name');
        return response()->json(['name' => $name]);
    }

    public function store(ProjectNameRequest $request) 
    {
        $user = Auth::user();
        $validatedData = $request->validated();
        try {
            DB::beginTransaction();
            $project = $user->projects()->create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);
            DB::commit();
            return response()->json(["project" => $project]);
        } catch (ValidationException $error) {
            // バリデーションエラーの場合のレスポンス
            DB::rollBack();
            return response()->json([
                'message' => '入力データが無効です。',
                'errors' => $error->errors(),
            ], 422);
    
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'message' => 'プロジェクトの作成に失敗しました。',
                'error' => $error->getMessage(),
            ], 500);
        }
        
    }
}
