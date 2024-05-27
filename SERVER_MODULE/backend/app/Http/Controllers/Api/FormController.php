<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forms = Form::get();

        return response()->json([
            "message" => "Get all forms success",
            "forms" => $forms,
            "status" => 200,
        ]);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|regex:/^[A-Za-z. -]+$/|unique:forms',
            'allowed_domains' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "status" => 422,
                "errors" => $validator->messages()
            ]);
        }

        $form = Form::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'allowed_domains' => $request->allowed_domains,
            'description' => $request->description,
            'limit_one_response' => $request->limit_one_response
        ]);

        return response()->json([
            'messages' => 'Create form success',
            'data' => $form,
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $form = Form::whereSlug($slug)->first();
        $form['questions'] = $form->questions;

        return response()->json([
            "message" => "Get form success",
            "forms" => $form,
            "status" => 200,
        ]);
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
    public function destroy($id)
    {
        //
    }
}
