@extends('layouts.app')

@section('content')

    <h1 class="text-center my-3  text-info">All users</h1>
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
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $item)
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <th>{{$item->name}}</th>
                            <th>{{$item->email}}</th>
                            <th class="actions">
                                <a href="#" class="text-warning" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="#" class="text-danger" title="Delete"><i class="fa-solid fa-trash"></i></a>
                            </th>

                        </tr>
                    @endforeach
                </table>
        </div>
    </div>
@endsection
