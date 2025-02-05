<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;



class PageComponentController extends Controller
{
    public function store(Request $request) 
{
    $name = $request->input('name');
    $page = $request->input('page');
    $project = Project::where('name', $name)->first();

    if (!$project) {
        return response()->json(['message' => 'Project not found'], 404);
    }

    $pageRecord = $project->pages()->where('name', $page)->first();
    if (!$pageRecord) {
        return response()->json(['message' => 'Page not found'], 404);
    }

    $page_id = $pageRecord->id;
    $components = $request->input('droppedItems');

    if (empty($components)) {
        return response()->json(['message' => 'No components provided'], 400);
    }

    DB::transaction(function () use ($components, $page_id) {
        $pageComponents = [];
        $squares = [];
        $texts = [];
        $hyperLinks = [];

        foreach ($components as $component) {
            if (!is_array($component)) {
                throw new \Exception('Component must be an array');
            }
            if (!isset($component['type'])) {
                throw new \Exception('Missing "type" key in component');
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
                    throw new \Exception("Unsupported component type: " . $component['type']);
            }
        }

        


            
        if (!empty($pageComponents)) {
            DB::table('page_components')->insert($pageComponents);
        }
        if (!empty($squares)) {
            DB::table('squares')->insert($squares);
        }
        if (!empty($texts)) {
            DB::table('texts')->insert($texts);
        }
        if (!empty($hyperLinks)) {
            DB::table('hyper_links')->insert($hyperLinks);
        }
    });

    return response()->json(['message' => 'Components saved successfully']);
}


}
