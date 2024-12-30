<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectNameRequest;

class ProjectController extends Controller
{
    public function store(ProjectNameRequest $request) 
    {
        $user = Auth::user();
        $validatedData = $request->validated();
        $project = $user->projects()->create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        return response()->json(["project" => $project]);
    }
}
