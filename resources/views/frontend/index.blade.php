@extends('frontend.layouts.app')

@section('head')
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Service",
          "name": "LogistiQuote",
          "description": "Providing competitive freight shipping rates, quick responses for quotes, credit solutions, and efficient freight booking services.",
          "serviceType": "International Freight Forwarding",
          "provider": {
            "@type": "Organization",
            "name": "LogistiQuote",
             "url": "https://logistiquote.com"
          }
        }
    </script>
@endsection

@section('content')
    <div class="main-content">
        @include('panels.includes.errors')
        <div class="wrapper-home-pages">
            <section class="wrapper-header-block">
                <div class="container body">
                    <div class="left-column">
                        <div class="delivery-illustrations">
                        </div>
                        <div class="text-block">
                            <p>Shipping to and from anywhere</p>
                            <h1>FIND THE BEST FREIGHT QUOTE</h1>
                        </div>
                    </div>
                    <div class="right-column">
                        <div class="switcher">
                            <button id="freight-quote-btn" class="active">Freight Quotes</button>
                            <button id="container-tracking-btn">Container Tracking</button>
                        </div>
                        <div id="freight-quote-form" class="form active">
                            @include('frontend.index.quote',['origins' => $origins,'destinations' => $destinations])
                        </div>
                        <form id="container-tracking-form" class="form" method="GET">
                            <div class="input-group">
                                <label class="quotation-label">Tracking number</label>
                                <input type="text" placeholder="Container Number/Code"/>
                            </div>
                            <div class="input-group">
                                <label class="quotation-label">Select sealine</label>
                                <input type="text" placeholder="Auto Detect"/>
                            </div>
                            <button type="submit" class="submit-button">Search</button>
                        </form>
                    </div>
                </div>
            </section>
            @include('frontend.index.benefits')
            @include('frontend.index.faq')
            <div class="wrapper-cookies">
                <div class="cookies">
                    <span class="cookies-text">
                        By using this website, you agree to <a target="_blank" href="#">our privacy policy</a>
                    </span>
                    <div class="cookies-button">
                        <a>OK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //switching between forms
        const freightQuoteBtn = document.getElementById('freight-quote-btn');
        const containerTrackingBtn = document.getElementById('container-tracking-btn');
        const freightQuoteForm = document.getElementById('freight-quote-form');
        const containerTrackingForm = document.getElementById('container-tracking-form');

        freightQuoteBtn.addEventListener('click', () => {
            freightQuoteBtn.classList.add('active');
            containerTrackingBtn.classList.remove('active');
            freightQuoteForm.classList.add('active');
            containerTrackingForm.classList.remove('active');
        });

        containerTrackingBtn.addEventListener('click', () => {
            containerTrackingBtn.classList.add('active');
            freightQuoteBtn.classList.remove('active');
            containerTrackingForm.classList.add('active');
            freightQuoteForm.classList.remove('active');
        });
    </script>
@endsection
