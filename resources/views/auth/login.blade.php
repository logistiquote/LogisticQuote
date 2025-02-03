@extends('frontend.layouts.app')
@section('content')

<div id="authApps">
    <section class="section-login">
        <div class="content">
            <div class="sign-form">
                <div class="sign-form_content">
                    <form class="sign-form_content-input-part form active" action="{{ route('login') }}" method="POST">
                        @csrf
                        <legend class="sign-form_content-title">Sign in</legend>

                        <div class="input-wrapper @error('email') error @enderror">
                            <input
                                type="text"
                                name="email"
                                placeholder="E-mail"
                                autocomplete="off" autocapitalize="off" spellcheck="false"
                                style="width: 100%"
                            >
                                @error('email')
                                    <p class="errorInputMsg">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="input-wrapper @error('password') error @enderror">
                            <input
                                type="password"
                                name="password"
                                autocomplete="off" placeholder="Password"
                                style="width: 100%"
                            >
                                @error('password')
                                    <p class="errorInputMsg">{{ $message }}</p>
                                @enderror
                            </div>

                        <button type="submit" class="sign-form_content-main-btn submit-button">Sign in</button>
                    </form>
                    <div class="sign-form_content-reg-part">
                        <p>Don't have a LogistiQuote account yet?</p><a href="{{ route('register') }}">Sign Up</a>
                    </div>
                    <div class="sign-form_content-frgt-psw"><a class="sign-form_content-addtnl-opt_forgot-psw"
                            href="{{ route('password.request') }}">Forgot Password?</a></div>
                    <div class="sign-form_content-agree-terms">
                        <p>By signing in or creating an account, you agree with our <a target="_blank" href="/tos">Terms
                                &amp; conditions</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
