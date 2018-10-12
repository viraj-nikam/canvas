@extends('canvas::layouts.admin')

@section('title', config('app.name', 'Laravel'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Canvas</div>

                    <div class="card-body">
                        Welcome to the Admin section of Canvas!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
