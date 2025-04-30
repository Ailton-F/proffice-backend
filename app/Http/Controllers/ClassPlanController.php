<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassPlanPatchRequest;
use App\Http\Requests\ClassPlanPostResquest;
use App\Models\ClassPlan;
use Illuminate\Support\Facades\Auth;

class ClassPlanController extends Controller
{
    public function show($id)
    {
        $class = ClassPlan::find($id);

        if (!$class) {
            return response()->json(['message' => 'Class plan not found'], 404);
        }

        return $class;
    }

    public function store(ClassPlanPostResquest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        return ClassPlan::create($data);
    }

    public function update(ClassPlanPatchRequest $request, $id)
    {
        $data = $request->validated();
        $class = ClassPlan::find($id);
        $current_user = Auth::user();

        if ($class->user_id !== $current_user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$class) {
            return response()->json(['message' => 'Class plan not found'], 404);
        }

        $class->update($data);
        return $class;
    }

    public function destroy($id)
    {
        $class = ClassPlan::find($id);
        $current_user = Auth::user();

        if ($class->user_id !== $current_user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$class) {
            return response()->json(['message' => 'Class plan not found'], 404);
        }

        $class->delete();
        return response()->json(['message' => 'Class plan deleted successfully'], 200);
    }
}
