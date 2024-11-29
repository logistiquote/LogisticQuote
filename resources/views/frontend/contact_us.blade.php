@extends('frontend.layouts.app')
@section('content')

<div class="main-content">
    <div class="cu-bottom container">
        <h1 class="main-title" data-text="Contact Us">Contact Us</h1>
        <div style="width: 100%;">
            <div class="cu-const-info">
                <div class="cu-info-content">
                    <div class="cu-ci-line">
                        <h4>Address</h4> 
                        <a href="#" target="_blank">
                            P.O Box xyx, Tel Aviv, Israel
                        </a>
                    </div>
                    <div class="cu-ci-text">
                        <h4>Email</h4> <a href="mailto:cs@logistiquote.com">cs@logistiquote.com</a>
                    </div>
                </div>
            </div>
            <div id="cu-form">
                <div class="cu-const-msg">
                    <form id="contact_form" method="POST" action="{{ route('contact') }}" >
                        @csrf
                        <div class="form-row">
                            <div class="form-col">
                                
                                <div class="dynamic-placeholder"> 
                                    <input class="input-dark" required="" name="subject" type="text" placeholder="Subject"> 
                                </div>

                                <div class="dynamic-placeholder"> 
                                    <input class="input-dark" required="" name="name" type="text" placeholder="Name"> 
                                </div>

                                <div class="dynamic-placeholder"> 
                                    <input class="input-dark" required="" name="phone" type="number" placeholder="Phone"> 
                                </div>

                                
                                <div class="dynamic-placeholder"> 
                                    <input class="input-dark" required="" name="email"
                                        id="form-field-3" type="email" placeholder="E-mail"> 
                                </div>

                            </div>
                            
                            <div class="form-col"> 
                                <textarea name="message" id="form-field-4" rows="7" placeholder="Message"></textarea>

                                <div class="input-wrapper"> 
                                    <input class="cu-input-submit" type="submit" value="Send"> 
                                </div>
                            </div>
                        </div>
                        <div id="valid_captcha"><input type="hidden" name="c" value="valid"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
