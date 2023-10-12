@extends('layouts.app')

@section('content')
    <h1 class="text-center my-3  text-info">Upload File</h1>
    <div class="container col-md-6">
        @if(Session::has('done'))
            <div class="alert alert-success" style="display: flex ;justify-content: space-between;">
                {{Session::get("done")}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            @if ($errors->any())
                <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
            @endif
        <div class="card p-4">
            <div class="card-body">
               <form action="{{route('drive.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                   <div class="form-group">
                        <label for="title" class="mt-1">Title</label>
                        <input type="text" id="title" name="title" class="form-control m-3" >

                        <label for="desc">Description</label>
                        <input type="text" name="desc" id="desc" class="form-control m-3" >

                        <label for="category" >Choose Category</label>
                        <select name="category" class="form-control m-3" id="category">
                        @foreach ($category as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                        </select>
                        <label for="file">Choose File</label>
                        <input type="file" id="file" name="file" class="form-control m-3" >

                        <div class="form-group">
                            <input type="submit" value="Upload File" class="form-control btn btn-primary m-3">
                        </div>
                   </div>
                </form>
            </div>
        </div>
    </div>
@endsection
