@extends('admin.layout')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('Fee Structure') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('fee-structure.index') }}">{{ __('Fee Structure') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Edit Fee Structure') }}</li>
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

                        {{ $item->academic_year_id }}

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Edit Fee Structure') }}</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('fee-structure.update',  $item->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $item->id }}" />
                                    <div class="grid-three-column">
                                        <div class="grid-item">
                                            <label for="academic_year_id">{{ __('Academic Year') }}</label>
                                            <select name="academic_year_id" id="academic_year_id" class="form-control">
                                                <option value="" disabled selected>{{ __('Select One') }}</option>
                                                @foreach ($academicYears as $option)
                                                    <option value="{{ $option->id }}" @selected($option->id == old('academic_year_id', $item->academic_year_id))>
                                                        {{ $option->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('academic_year_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="grid-item">
                                            <label for="class_id">{{ __('Class') }}</label>
                                            <select name="class_id" id="class_id" class="form-control">
                                                <option value="" disabled selected>{{ __('Select One') }}</option>
                                                @foreach ($classes as $option)
                                                    <option value="{{ $option->id }}" @selected($option->id == old('class_id', $item->class_id))>
                                                        {{ $option->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('class_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="grid-item">
                                            <label for="fee_head_id">{{ __('Fee Head') }} {{ old('fee_head_id') }}</label>
                                            <select name="fee_head_id" id="fee_head_id" class="form-control">
                                                <option value="" disabled selected>{{ __('Select One') }}</option>
                                                @foreach ($feeHeads as $option)
                                                    <option value="{{ $option->id }}" @selected($option->id == old('fee_head_id', $item->fee_head_id))>
                                                        {{ $option->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('fee_head_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        @foreach ($months_fields as $field_name => $month_name)
                                            <div class="grid-item">
                                                <label for="{{ $field_name }}">{{ $month_name }}</label>
                                                <input type="text" class="form-control" id="{{ $field_name }}"
                                                    name="{{ $field_name }}"
                                                    value="{{ old($field_name, $item->$field_name) }}"
                                                    placeholder="{{ __('Enter Fee ' . $month_name) }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit"
                                            class="btn btn-primary">{{ __('Update Fee Structure') }}</button>
                                        <a href="{{ route('fee-structure.index') }}"
                                            class="btn btn-default float-right"">{{ __('Back') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
