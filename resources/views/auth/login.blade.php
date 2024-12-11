@extends('frontend.layouts.app')

@section('content')

<div id="authApps">
    <section class="section-login">
        <div class="content">
            <!-- <div class="sign-img"><img alt="man registers by tablet"
                    src="#"></div> -->
            <div class="sign-form">
                <div class="sign-form_content">
                    <form class="sign-form_content-input-part" action="{{ route('login') }}" method="POST">
                        @csrf
                        <legend class="sign-form_content-title">Sign in</legend>

                        <div class="input-wrapper @error('email') error @enderror">
                            <input class="input" type="text" placeholder=" " name="email"
                                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
                                <span class="placeholder">E-mail</span>
                                @error('email')
                                    <p class="errorInputMsg">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="input-wrapper @error('password') error @enderror">
                            <input class="input" type="password" name="password"
                                autocomplete="off" placeholder=" ">
                                <span class="placeholder">Password</span>
                                @error('password')
                                    <p class="errorInputMsg">{{ $message }}</p>
                                @enderror
                            </div>

                        <button type="submit" class="sign-form_content-main-btn">Sign in</button>
                    </form>
                    <div class="sign-form_content-reg-part">
                        <p>Don't have a LogistiQuote account yet?</p><a href="{{ route('register') }}">Sign Up</a>
                    </div>
                    <!-- <div class="sign-form_content-addtnl-sign ">
                        <p class="sign-form_content-addtnl-sign_title ">Or sign in with</p>
                        <div class="sign-form_content-addtnl-sign_social-net ">
                            <a
                                class="sign-form_content-addtnl-sign_social-net-btn">
                                <div class="sign-form_content-addtnl-sign_social-net-btn-icon-part ">
                                    <img
                                        src="https://www.LogistiQuote.com/design/images/apps/login/icon_google.png"
                                        alt="google logo icon"></div>
                                <div class="sign-form_content-addtnl-sign_social-net-btn-text-part ">
                                    <p>Google</p>
                                </div>
                            </a><a class="sign-form_content-addtnl-sign_social-net-btn">
                                <div class="sign-form_content-addtnl-sign_social-net-btn-icon-part "><img
                                        src="https://www.LogistiQuote.com/design/images/apps/login/icon_facebook.png"
                                        alt="facebook logo icon"></div>
                                <div class="sign-form_content-addtnl-sign_social-net-btn-text-part ">
                                    <p>Facebook</p>
                                </div>
                            </a></div>
                    </div> -->
                    <div class="sign-form_content-frgt-psw"><a class="sign-form_content-addtnl-opt_forgot-psw"
                            href="{{ route('password.request') }}">Forgot Password?</a></div>
                    <div class="sign-form_content-agree-terms">
                        <p>By signing in or creating an account, you agree with our <a target="_blank" href="/tos">Terms
                                &amp; conditions</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- <nav class="bottom-links"><a href="/contact" target="_blank">Contact us &amp; Feedback</a><a
                href="/contact/shippers-help " target="_blank">Help</a><a href="/privacy" target="_blank">Privacy</a>
        </nav> -->
    </section>
</div>

@endsection
