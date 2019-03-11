@extends('canvas::index')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between">
                    <h1 class="mb-4 mt-2">Settings</h1>
                </div>

                <div class="d-flex border-top py-3 align-items-center">
                    <div class="mr-auto">
                        <p class="mb-0 py-1 font-weight-bold lead">
                            Your email
                        </p>
                    </div>
                    <div class="ml-auto">
                        {{ auth()->user()->email }}
                    </div>
                </div>

                <div class="d-flex border-top py-3 align-items-center">
                    <div class="mr-auto">
                        <p class="mb-1 font-weight-bold lead">Weekly summaries</p>
                        <p class="mb-0">We'll email you a summary of how well your posts did each week.</p>
                    </div>
                    <div class="ml-auto">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="summaries">
                            <label class="custom-control-label" for="summaries"></label>
                        </div>
                    </div>
                </div>

                <div class="d-flex border-top py-3 align-items-center">
                    <div class="mr-auto">
                        <p class="mb-1 font-weight-bold lead">Download your information</p>
                        <p class="mb-0">Download a copy of the information you’ve posted with Canvas to a .zip file.</p>
                    </div>
                    <div class="ml-auto">
                        <div class="custom-control custom-switch">
                            <a href="#" class="btn btn-outline-secondary btn-sm">Download .zip</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
