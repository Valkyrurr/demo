@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="clearfix"></div>
                    {{-- todo: No hint path defined for [flash] --}}
                    {{--@include('flash::message')--}}
                <div class="clearfix"></div>

                <div class="card">
                    <div class="card-header">{{ __('Organization') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url(str_slug('init tenant')) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Organization Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tenant" class="col-md-4 col-form-label text-md-right">{{ __('Organization Name') }}</label>

                                <div class="col-md-6">
                                    <input id="tenant" type="text" class="form-control{{ $errors->has('tenant') ? ' is-invalid' : '' }}" name="tenant" value="{{ old('tenant') }}" required autofocus>

                                    @if ($errors->has('tenant'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('tenant') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
