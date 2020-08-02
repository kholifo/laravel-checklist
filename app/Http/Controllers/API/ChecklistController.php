<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Checklist;
use App\Item;

class ChecklistController extends Controller
{
    public function store(Request $request)
    {
        $checklist_name = $request->input('checklist_name');

        $data = array(
            'checklist_name' => $checklist_name
        );

        $checklist = Checklist::create($data);

        if ($checklist) {
            return response()->json([
                'data' => [
                    'type' => 'checklists',
                    'message' => 'Success',
                    'id' => $checklist->id,
                    'attributes' => $checklist
                ]
            ], 201);
        } else {
            return response()->json([
                'type' => 'checklists',
                'message' => 'Fail'
            ], 400);
        }
    }

    public function storeLists(Request $request, $checklist_id)
    {
        $item_name = $request->input('item_name');

        $item = Item::create([
            'item_name' => $item_name,
            'checklist_id' => $checklist_id,
            'status' => 0
        ]);

        if ($item) {
            return response()->json([
                'data' => [
                    'type' => 'checklist items',
                    'message' => 'Success',
                    'id' => $item->id,
                    'attributes' => $item
                ]
            ], 201);
        } else {
            return response()->json([
                'type' => 'checklist_items',
                'message' => 'Fail'
            ], 400);
        }
    }

    public function show()
    {
        $checklists = Checklist::with('items')->get();

        return response()->json([
            'data' => $checklists
        ], 200);
    }

    public function checklistUpdate(Request $request, $checklist_id)
    {
        $checklist = Checklist::find($checklist_id);

        if ($checklist) {
            $checklist->checklist_name = $request->input('checklist_name');
            $checklist->save();

            return response()->json([
                'data' => [
                    'type' => 'checklists',
                    'message' => 'Update Success',
                    'id' => $checklist->id,
                    'attributes' => $checklist
                ]
            ], 201);
        } else {
            return response()->json([
                'type' => 'checklists',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function itemUpdate(Request $request, $checklist_id, $item_id)
    {
        $item = Item::where('checklist_id', $checklist_id)->where('id', $item_id)->first();

        if ($item) {
            $item->item_name = $request->input('item_name');
            $item->status = $request->input('status');
            $item->save();

            return response()->json([
                'data' => [
                    'type' => 'items',
                    'message' => 'Update Success'
                ]
            ], 201);
        } else {
            return response()->json([
                'type' => 'items',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getChecklistById($checklist_id)
    {
        $checklist = Checklist::with('items')->find($checklist_id);

        if ($checklist) {
            return response()->json([
                'data' => [
                    'type' => 'checklists',
                    'message' => 'Success',
                    'attributes' => $checklist
                ]
            ], 200);
        } else {
            return response()->json([
                'type' => 'checklists',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function checklistDestroy($checklist_id)
    {
        $checklist = Checklist::find($checklist_id);

        if ($checklist) {
            $checklist->delete();

            return response()->json([], 204);
        } else {
            return response()->json([
                'type' => 'checklists',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function checklistItemDestroy($checklist_id, $item_id)
    {
        $item = Item::where('checklist_id', $checklist_id)->where('id', $item_id)->first();

        if ($item) {
            $item->delete();

            return response()->json([], 204);
        } else {
            return response()->json([
                'type' => 'items',
                'message' => 'Not Found'
            ], 404);
        }
    }
}
