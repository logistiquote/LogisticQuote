@extends('frontend.layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">{{ __('Verify Your Email Address') }}</h1>
                                        @if (session('resent'))
                                            <div class="alert alert-success" role="alert">
                                                {{ __('A fresh verification link has been sent to your email address.') }}
                                            </div>
                                        @endif

                                        {{ __('Before proceeding, please check your email for a verification link.') }}

                                        {{ __('If you did not receive the email') }},
                                        <form class="mt-2 sign-form_content-input-part form active" method="POST" action="{{ route('verification.resend') }}">
                                            @csrf
                                            <button type="submit" class="sign-form_content-main-btn submit-button">
                                                {{ __('click here to request another') }}
                                            </button>
                                            .
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
