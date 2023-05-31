@extends('layouts.master')
@section('headlinks')
@endsection
@section('contents')
<div class="row">

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-block card-stretch card-height">
            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                <div class="header-title">
                    <h4>No of Movies</h4>
                </div><b style="font-size: 25px">{{$movieCount}}</b>
            </div>

        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-block card-stretch card-height">
            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                <div class="header-title">
                    <h4>No of Movies</h4>
                </div>
                <div><b style="font-size: 25px">{{$movieCount}}</b>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between  mb-3">
                    <div class="w-100">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-block card-stretch card-height">
            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                <div class="header-title">
                    <h4>No of Movies</h4>
                </div>
                <div><b style="font-size: 25px">{{$movieCount}}</b>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between  mb-3">
                    <div class="w-100">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
