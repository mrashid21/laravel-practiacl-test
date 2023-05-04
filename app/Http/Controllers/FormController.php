<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use Auth;

class FormController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $forms = Form::all();
        return view('forms.index', compact('forms'));
    }

    public function survey($id)
    {
        $form = Form::with('inputs')->where('id', $id)->first();

        return view('forms.survey', compact('form'));
    }

    public function submitSurvey(Request $request)
    {
    	$submit = $request->except('_token');
    	return view('forms.submit', compact('submit'));
    }
}
