<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Input;
use App\Http\Requests\Api\v1\Input\CreateRequest;
use App\Resources\Api\v1\InputResource;

class InputController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $inputs = Input::all();
        return response()->json([
            'status' => 'success',
            'data' => InputResource::collection($inputs),
        ]);
    }

    public function store(CreateRequest $request)
    {
        $input = Input::create([
            'name' => strtolower(str_replace(' ', '_', $request->name)),
            'type' => $request->type,
            // 'user_id' => Auth::user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Input created successfully',
            'data' => InputResource::make($input),
        ]);
    }

    public function show($id)
    {
        $input = Input::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $input,
        ]);
    }

    public function update(CreateRequest $request, $id)
    {
        $input = Input::find($id);
        $input->name = strtolower(str_replace(' ', '_', $request->name));
        $input->type = $request->type;
        $input->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Input updated successfully',
            'data' => $input,
        ]);
    }

    public function destroy($id)
    {
        $input = Input::find($id);
        $input->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Input deleted successfully',
            'data' => $input,
        ]);
    }
}
