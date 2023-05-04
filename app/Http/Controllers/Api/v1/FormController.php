<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Form;
use App\Models\Input;
use App\Http\Requests\Api\v1\Form\CreateRequest;
use App\Http\Requests\Api\v1\Form\AttachInputRequest;
use App\Resources\Api\v1\FormResource;
use Auth;

class FormController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $forms = Form::with('inputs')->get();
        return response()->json([
            'status' => 200,
            'data' => FormResource::collection($forms),
        ]);
    }

    public function store(CreateRequest $request)
    {
        $form = Form::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Form created successfully',
            'data' => FormResource::make($form),
        ]);
    }

    public function show($id)
    {
        $form = Form::with('inputs')->where('id', $id)->first();

        return response()->json([
            'status' => 200,
            'data' => FormResource::make($form),
        ]);
    }

    public function update(CreateRequest $request, $id)
    {
        $form = Form::find($id);
        $form->title = $request->title;
        $form->description = $request->description;
        $form->save();

        return response()->json([
            'status' => 200,
            'message' => 'Form updated successfully',
            'data' => FormResource::make($form),
        ]);
    }

    public function destroy($id)
    {
        $form = Form::find($id);
        $form->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Form deleted successfully',
            'data' => $form,
        ]);
    }

    public function toggleInputFields(AttachInputRequest $request)
    {
        $form = Form::find($request->form_id);

        if ($form->inputs()->exists($request->input_id) && $request->toggle) {
            return response()->json([
                'status' => 422,
                'message' => 'Input already attach to form',
                'data' => $form,
            ]);
        }

        if (!$form->inputs()->exists($request->input_id) && !$request->toggle) {
            return response()->json([
                'status' => 422,
                'message' => 'Input already detach to form',
                'data' => $form,
            ]);
        }

        if (!$form->inputs()->exists($request->input_id) && $request->toggle) {
            $form->inputs()->attach($request->input_id);

            return response()->json([
                'status' => 200,
                'message' => 'Input attach to form successfully',
                'data' => $form,
            ]);
        }

        if ($form->inputs()->exists($request->input_id) && !$request->toggle) {
            $form->inputs()->detach($request->input_id);

            return response()->json([
                'status' => 200,
                'message' => 'Input detach to form successfully',
                'data' => $form,
            ]);
        }

    }
}
