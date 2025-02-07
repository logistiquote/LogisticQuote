@extends('frontend.layouts.app')
@section('content')
    <div class="main-content mt-5">
        <div class="container">
            <div class="contact-block">
                <h2 class="section-title">Contact Us</h2>
                <div class="contact-item">
                    <h3 class="contact-subtitle">Address</h3>
                    <p class="contact-detail">Moshe Aviv St 4 Or Yehuda, Tel Aviv Israel</p>
                </div>
                <div class="contact-item">
                    <h3 class="contact-subtitle">Email</h3>
                    <p class="contact-detail">support@logistiquote.com</p>
                </div>
            </div>
            <div class="form-container">
                <form class="form contact-us-form active" method="POST" action="{{ route('contact') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="input-group">
                            <input required name="subject" type="text" placeholder="Subject">
                        </div>
                        <div class="input-group">
                            <input required name="name" type="text" placeholder="Name">
                        </div>
                        <div class="input-group">
                            <input required name="phone" type="number" placeholder="Phone">
                        </div>
                        <div class="input-group">
                            <input required name="email" type="email" placeholder="Email">
                        </div>
                    </div>
                    <textarea name="message" rows="7" required minlength="10" placeholder="Message"></textarea>

                    @include('components.recaptcha', ['action' => 'contact-us'])

                    <button type="submit" class="submit-button">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
