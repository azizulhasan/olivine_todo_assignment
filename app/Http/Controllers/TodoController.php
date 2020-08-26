<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Todo;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $todos = Todo::withTrashed()->get()->sortByDesc('id');
        return view("todo")->with(['todos'=> $todos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'title' => ['required','max:255' ],
        ]);
        if ($validator->fails())
        { 
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }else{
        $data =[
            'title'=>$request->title
        ];
        Todo::insert($data);
        $todos = Todo::withTrashed()->get()->sortByDesc('id');
    }
        
        return redirect("todo")->with(['todos'=> $todos, 'message'=> 'Todo Created']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        
        $singleTodo = Todo::withTrashed()->find($todo->id);
        $todos = Todo::withTrashed()->get()->sortByDesc('id');
        return view("todo")->with(['todos'=> $todos, 'singleTodo'=> $singleTodo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $data = [
            'title'=> $request->title
        ];
        Todo::where(['id'=>$request->id])->update($data);
        $todos = Todo::withTrashed()->get()->sortByDesc('id');
        return redirect("todo")->with(['todos'=> $todos,'message'=> 'Todo Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        $todos = Todo::withTrashed()->get()->sortByDesc('id');
        return redirect("todo")->with(['todos'=> $todos, 'message'=> 'Todo Deleted']);
    }
}
