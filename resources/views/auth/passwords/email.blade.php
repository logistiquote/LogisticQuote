@extends('frontend.layouts.app')

@section('content')
    <div id="authApps">
        <section class="section-login">
            <div class="content">
                <div class="sign-form">
                    <div class="sign-form_content">
                        <form method="POST" action="{{ route('password.email') }}"
                              class="sign-form_content-input-part form active">
                            @csrf
                            <legend class="sign-form_content-title">
                                {{ __('Forgot password') }}
                            </legend>

                            <div class="input-wrapper">
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="E-mail"
                                    required
                                    autocomplete="email"
                                    autofocus
                                >
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="sign-form_content-main-btn submit-button">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
