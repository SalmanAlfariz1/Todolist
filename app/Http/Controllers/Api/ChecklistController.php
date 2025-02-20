<?php

namespace App\Http\Controllers\Api;

use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChecklistController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string']);

        $checklist = Checklist::create([
            'title' => $request->title,
            'user_id' => auth()->guard('api')->user()->id
        ]);

        return response()->json(['message' => 'Checklist created', 'data' => $checklist]);
    }

    public function destroy($id)
    {
        $checklist = Checklist::where('user_id', auth()->guard('api')->user()->id)
            ->where('id', $id)
            ->first();

        // if checklist not found
        if (!$checklist) {
            return response()->json(['message' => 'Checklist not found'], 404);
        }

        $checklist->delete();

        return response()->json(['message' => 'Checklist deleted']);
    }

    public function index()
    {
        $checklists = Checklist::where('user_id', auth()->guard('api')->user()->id)->with('items')->get();
        return response()->json($checklists);
    }

    public function show($id)
    {
        $checklist = Checklist::where('user_id', auth()->guard('api')->user()->id)
            ->where('id', $id)
            ->with('items')
            ->first();

        // if checklist not found
        if (!$checklist) {
            return response()->json(['message' => 'Checklist not found'], 404);
        }

        return response()->json($checklist);
    }
}
