<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'choice_type' => 'required|in:short answer,paragraph,date,multiple choice,dropdown,checkboxes',
            'choices' => Rule::requiredIf(function () use ($request) {
                return $request->input('choice_type') == 'multiple choice' || $request->input('choice_type') == 'dropdown' || $request->input('choice_type') == 'checkboxes';
            })
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "status" => 422,
                "errors" => $validator->messages()
            ]);
        }

        $question = $request->all();
        $question['form_id'] = Form::where('slug', $slug)->first()['id'];
        $question['choices'] = implode(',', $question['choices']);

        $question = Question::create($question);

        if (!$question) {
            return response()->json([
                "message" => "Something went wrong",
                "status" => 500
            ]);
        }

        return response()->json([
            "message" => "Add question success",
            "question" => $question,
            "status" => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return response()->json([
            "message" => "Remove question success",
            "status" => 200
        ]);
    }
}
