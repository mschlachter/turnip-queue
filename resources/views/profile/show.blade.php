@extends('layouts.app')

@push('meta')
<meta name="robots" content="noindex">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Update Profile')</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form id="form-seeker-details" method="post" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">
                                @lang('Name')
                            </label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" maxlength="255" value="{{ old('name', $user->name) }}" />
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">
                                @lang('E-Mail Address')
                            </label>
                            <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" maxlength="20" readonly="readonly" value="{{ $user->email }}" aria-describedby="email-helptext" />
                            <small class="text-muted" id="email-helptext">
                                @lang('Email address cannot be changed')
                            </small>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            @lang('Save')
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mt-4" id="password-section">
                <div class="card-header">@lang('Change Password')</div>

                <div class="card-body">
                    @if (session('password-status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('password-status') }}
                    </div>
                    @endif

                    <form id="form-seeker-details" method="post" action="{{ route('profile.update-password') }}">
                        @csrf
                        <div class="form-group">
                            <label for="password">
                                @lang('Current Password')
                            </label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" maxlength="255" />
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">
                                @lang('New Password')
                            </label>
                            <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" maxlength="255" />
                            @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">
                                @lang('Confirm Password')
                            </label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" maxlength="255" />
                            @error('new_password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            @lang('Change Password')
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">@lang('Danger Zone')</div>

                <div class="card-body">
                    <p>
                        @lang('Account deletion is permenant, once deleted your account cannot be restored.')
                    </p>
                    <form id="form-seeker-details" method="post" action="{{ route('profile.delete') }}" data-confirm="@lang('Are you sure you want to delete your account? This action cannot be undone.')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">
                            @lang('Delete Account')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
