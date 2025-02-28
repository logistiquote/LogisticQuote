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

            @include('frontend.index.benefits')
            @include('frontend.index.faq')
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
