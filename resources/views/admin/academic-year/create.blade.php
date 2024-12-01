@extends('admin.layout')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('Academic Year') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('academic-year.index') }}">{{ __('Academic Year') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Add Academic Year') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                        @endif

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Add Academic Year') }}</h3>
                            </div>


                            <form method="POST" action="{{ route('academic-year.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">{{ __('Academic Year') }}</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="{{ __('Enter Academic Year') }}">

                                            @error('name')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>                                                
                                            @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">{{ __('Add Academic Year') }}</button>
                                    <a href="{{ route('academic-year.index') }}" class="btn btn-default float-right"">{{ __('Back') }}</a>                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection