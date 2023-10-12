@extends('layouts.app')

@section('content')
    <h1 class="text-center my-3  text-info">{{$drive->title}}</h1>
    <div class="container col-md-6">
        @if(Session::has('done'))
            <div class="alert alert-success" style="display: flex ;justify-content: space-between;">
                {{Session::get("done")}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card m-auto p-4">
            @if ($drive->extension == 'jpg' ||$drive->extension == 'png' ||$drive->extension == 'webp')
                {{-- <img src="{{ asset("upload/drive/{{$drive->file}}") }}"> --}}
                <img src="{{ asset('upload/drive/' . $drive->file) }}">
            @else
            <img src="{{asset('img/download-158006_1280.webp')}}"  alt="...">
            @endif
            <div class="card-body mt-5">
              <h4 class="card-title">Title : {{$drive->title}}</h4>
              <hr>
              <h5 class="card-text">Description :  {{$drive->description}}</h5>
              <hr>
              <h6>File Extension :  {{$drive->extension}}</h6>
              <hr>
              <a href="{{route('drive.download' ,$drive->id)}}" class="btn btn-primary"><i class="fa-solid fa-download"></i> Download</a>
            </div>
          </div>
    </div>
@endsection
