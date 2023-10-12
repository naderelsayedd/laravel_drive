@extends('layouts.app')

@section('content')

    <h1 class="text-center my-3  text-info">Public Files</h1>
    <div class="container col-md-6">
        @if(Session::has('done'))
            <div class="alert alert-success" style="display: flex ;justify-content: space-between;">
                {{Session::get("done")}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card p-4">
            <div class="card-body">
                <table class="table table-light text-center">
                    <tr>
                        <th>Num</th>
                        <th>Name</th>
                        <th>Action</th>
                        <th>Author</th>
                    </tr>
                    @foreach ($drive as $item)
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <th>{{$item->driveName}}</th>
                            <th class="actions">
                                <a href="{{route('drive.show' , $item->driveid)}}" class="text-primary" title="More Details"><i class="fa-solid fa-eye"></i></a>
                                {{-- <a href="{{route('drive.edit' , $item->id)}}" class="text-warning" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="{{route('drive.destroy' , $item->id)}}" class="text-danger" title="Delete"><i class="fa-solid fa-trash"></i></a> --}}
                            </th>
                            <th>{{$item->author}}</th>
                        </tr>
                    @endforeach
                </table>
        </div>
    </div>
@endsection
