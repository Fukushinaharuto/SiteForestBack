<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;



class PageComponentController extends Controller
{
    public function index(Request $request)
    {
        $projectName = $request->input('name');
        $pageName = $request->input('page');

        $page_id = DB::table('projects')
                    ->join('pages', 'projects.id', '=', 'pages.project_id')
                    ->where('projects.name', $projectName)
                    ->where('pages.name', $pageName)
                    ->value('pages.id');
        
        $pageComponents = DB::table('page_components')
        ->where('page_id', $page_id)
        ->get();

        if ($pageComponents->isEmpty()) {
            return response()->json(['message' => '存在しないpage_idが検出されました'], 404);
        }

        if (!$page_id) {
            return response()->json(['message' => 'page_idが存在が存在しません'], 404);
        }
        foreach ($pageComponents as $component) {
            switch ($component->type) {
                case 'square':
                    $component->details = DB::table('squares')
                                            ->where('page_component_id', $component->id)
                                            ->first();
                    break;

                case 'text':
                    $component->details = DB::table('texts')
                                            ->where('page_component_id', $component->id)
                                            ->first();
                    break;

                case 'hyperLink':
                    $component->details = DB::table('texts')
                                            ->where('page_component_id', $component->id)
                                            ->first();
                    $component->details->link = DB::table('hyper_links')
                                                    ->where('text_id', $component->id)
                                                    ->first();
                    break;
            }
        }
        return response()->json($pageComponents);
    }

    public function store(Request $request) 
    {
        $name = $request->input('name');
        $page = $request->input('page');
        $project = Project::where('name', $name)->first();

        if (!$project) {
            return response()->json(['message' => 'プロジェクトがありません'], 404);
        }

        $pageRecord = $project->pages()->where('name', $page)->first();
        if (!$pageRecord) {
            return response()->json(['message' => 'ページがありません'], 404);
        }

        $page_id = $pageRecord->id;
        $components = $request->input('droppedItems');

        if (empty($components)) {
            return response()->json(['message' => '保存する要素がありません。'], 400);
        }

        DB::transaction(function () use ($components, $page_id) {
            $pageComponents = [];
            $squares = [];
            $texts = [];
            $hyperLinks = [];

            foreach ($components as $component) {
                if (!is_array($component)) {
                    throw new \Exception('componentsが配列ではありません');
                }
                if (!isset($component['type'])) {
                    throw new \Exception('typeがありません');
                }
                $pageComponents[] = [
                    'id' => $component['id'],
                    'page_id' => $page_id,
                    'type' => $component['type'],
                    'top' => $component['y'],
                    'left' => $component['x'],
                    'width' => $component['width'],
                    'height' => $component['height'],
                    'color' => $component['color'] ?? '',
                    'unit' => $component['unit'] ?? 'px',
                    'border' => $component['border'],
                    'border_color' => $component['borderColor'] ?? '',
                    'opacity' => $component['opacity'],
                    'angle' => $component['angle'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                switch ($component['type']) {
                    case 'square':
                        $squares[] = [
                            'page_component_id' => $component['id'],
                            'borderRadius' => $component['borderRadius'] ?? '',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        break;

                    case 'text':
                        $texts[] = [
                            'id' => $component['id'],
                            'page_component_id' => $component['id'],
                            'text_color' => $component['textColor'],
                            'size' => $component['size'],
                            'font' => $component['font'] ?? 'default-font',
                            'children' => $component['children'] ?? '',
                            'text_align' => $component['textAlign'],
                            'vertical_align' => $component['verticalAlign'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        break;

                    case 'hyperLink':
                        $texts[] = [
                            'id' => $component['id'],
                            'page_component_id' => $component['id'],
                            'text_color' => $component['textColor'],
                            'size' => $component['size'],
                            'font' => $component['font'] ?? 'default-font',
                            'children' => $component['children'] ?? '',
                            'text_align' => $component['textAlign'],
                            'vertical_align' => $component['verticalAlign'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        $hyperLinks[] = [
                            'text_id' => $component['id'],
                            'href' => $component['href'] ?? '',
                            'is_link' => $component['isLink'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        break;

                    default:
                        throw new \Exception("そのtypeは存在しません: " . $component['type']);
                }
            }

            


                
            if (!empty($pageComponents)) {
                DB::table('page_components')->upsert($pageComponents, ['id'], [
                    'top', 'left', 'width', 'height', 'color', 'unit', 'border', 'border_color', 'opacity', 'angle', 'updated_at'
                ]);
            }
            if (!empty($squares)) {
                DB::table('squares')->upsert($squares, ['page_component_id'], ['borderRadius', 'updated_at']);
            }
            if (!empty($texts)) {
                DB::table('texts')->upsert($texts, ['page_component_id'], ['text_color', 'size', 'font', 'children', 'text_align', 'vertical_align', 'updated_at']);
            }
            if (!empty($hyperLinks)) {
                DB::table('hyper_links')->upsert($hyperLinks, ['text_id'], ['href', 'is_link', 'updated_at']);
            }
        });

        return response()->json(['message' => '保存に成功しました。']);
    }


}
