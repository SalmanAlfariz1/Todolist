<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function store(Request $request, $checklistId)
    {
        $request->validate(['content' => 'required|string']);

        $checklist = Checklist::where('user_id', auth()->guard('api')->user()->id)
            ->where('id', $checklistId)
            ->first();

        $item = $checklist->items()->create([
            'content' => $request->content,
            'status' => false
        ]);

        return response()->json(['message' => 'Item added', 'data' => $item]);
    }

    public function show($id)
    {
        $item = Item::find($id);

        // if item not found
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['content' => 'required|string']);

        $item = Item::find($id);

        // if item not found
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->update(['content' => $request->content]);

        return response()->json(['message' => 'Item updated', 'data' => $item]);
    }

    public function toggleStatus($id)
    {
        $item = Item::find($id);

        // if item not found
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->status = !$item->status;
        $item->save();

        return response()->json(['message' => 'Item status updated', 'data' => $item]);
    }

    public function destroy($id)
    {
        $item = Item::find($id);

        // if item not found
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }
}
