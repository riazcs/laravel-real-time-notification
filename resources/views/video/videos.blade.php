@extends('layouts.app')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mr-auto ml-auto mt-5">
        <h3 class="text-center">
            Videos
        </h3>
        
        @foreach($videos as $video)
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Videos</h5>
                </div>

                <div class="card-body">
                    <video src="{{asset($video->path)}}" controls="" style="width: 100%; height: auto"></video>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endSection