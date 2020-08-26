@extends('layouts.app')
@section('content')

<div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                @if(isset($singleTodo) && $singleTodo!="")
                    <form action="{{url('todo')}}/{{$singleTodo->id}}" method="post" class="form-inline">
                    @csrf
                    @method('PUT')
                    <div class="form-group mx-sm-1 mb-2">
                    <input type="text" name="title"  size="40" class="form-control" value="{{$singleTodo->title}}">

                    <input type="number" hidden name="id" value="{{$singleTodo->id}}"  size="40" class="form-control" placeholder="Enter Your todo">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </form>
                @else
                <form action="todo" method="post" class="form-inline">
                    @csrf
                    <div class="form-group mx-sm-1 mb-2">
                        <input type="text" name="title"  size="40" class="form-control" placeholder="Enter Your todo">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </form>
                @endif
            </div>
        </div>
        <div class="row">
        
            <div class="col-md-6 offset-md-3">
            <x-alert/>
                <table class="table">
                <tr class="heading">
                    <th>Id</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
                    @if(isset($todos) && count($todos)>0)
                    @foreach($todos as $todo)
                    <tr>
                        <td>{{$todo->id}}</td>
                        @if($todo->deleted_at !=null)
                        <td><del>{{$todo->title}}</del></td>
                        @else
                        <td>{{$todo->title}}</td>
                        @endif
                        
                        <td><a href="/todo/{{$todo->id}}/edit" class="btn btn-warning" >Edit</a>      
                        <a class="btn btn-danger" href="todo/{{$todo->id}}"
                            onclick="event.preventDefault();
                                            document.getElementById('delete-form').submit();">
                            {{ __('Delete') }}
                        </a>

                        <form id="delete-form" action="{{url('todo')}}/{{$todo->id}}" method="POST" style="display: none;">
                            @csrf
                            @method("DELETE")
                        </form>
                    
                    </td>
                    </tr>
                    @endforeach
                    @else
                    <p>There is no todo.</p>
                    @endif
                </table>
            </div>
        </div>
    </div>

@endsection