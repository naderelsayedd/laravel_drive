@extends('layouts.app')

@section('content')
    <h1 class="text-center my-3  text-info">Edit File :{{$drive->driveTitle}}</h1>
    <div class="container col-md-6">
        @if(Session::has('done'))
            <div class="alert alert-success" style="display: flex ;justify-content: space-between;">
                {{Session::get("done")}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card p-4">
            <div class="card-body">
               <form action="{{route('drive.update' ,$drive->driveId)}}" method="post" enctype="multipart/form-data">
                    @csrf
                   <div class="form-group">
                        <label for="title" class="mt-1">Title</label>
                        <input type="text" id="title" name="title" class="form-control m-3" value="{{$drive->driveTitle}}" required>

                        <label for="desc">Description</label>
                        <input type="text" name="desc" id="desc" class="form-control m-3" value="{{$drive->drivesDesc}}" required>

                        <label for="category" >Choose Category</label>
                        <select name="category" class="form-control m-3" id="category">
                            <option value="{{$drive->categoryId}}">{{$drive->categoryTitle}}</option>
                        @foreach ($category as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                        </select>
                        <label for="file">{{$drive->driveTitle}}</label>
                        <input type="file" id="file" name="file" class="form-control m-3"  value="{{$drive->file}}">

                        <div class="form-group">
                            <input type="submit" value="Save Changes" class="form-control btn btn-warning m-3">
                        </div>
                   </div>
                </form>
            </div>
        </div>
    </div>
@endsection
