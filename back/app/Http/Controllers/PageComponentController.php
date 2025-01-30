<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PageComponentController extends Controller
{
    public function store(Request $request) 
    {
        $components = $request->input();
        DB::transaction(function () use ($components) {
            $pageComponents = [];
            $squares = [];
            $texts = [];

            foreach ($components as $component) {
                $pageComponents[] = [
                    'page_id' => 1,
                    'type' => $component['type'],
                    'top' => $component['y'],
                    'left' => $component['x'],
                    'width' => $component['width'],
                    'height' => $component['height'],
                    'color' => $component['color'],
                    'unit' => $component['unit'],
                    'border' => $component['border'],
                    'border_color' => $component['borderColor'] ?? '',
                    'opacity' => $component['opacity'],
                    'angle' => $component['angle'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('page_components')->insert($pageComponents);
            $pageComponentIds = DB::getPdo()->lastInsertId();

            foreach ($components as $index => $component) {
                $pageComponentId = $pageComponentIds + $index;

                switch ($component['type']) {
                    case 'square':
                        $squares[] = [
                            'id' => $pageComponentId,
                            'borderRadius' => $component['borderRadius'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        break;

                    case 'text':
                        $texts[] = [
                            'id' => $pageComponentId,
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

                    default:
                        throw new \Exception("Unsupported component type: " . $component['type']);
                }
            }


            if (!empty($squares)) {
                DB::table('squares')->insert($squares);
            }
            if (!empty($texts)) {
                DB::table('texts')->insert($texts);
            }
        });

        return response()->json(['message' => 'Components saved successfully']);
    }

}
