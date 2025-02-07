@if (config('services.recaptcha.enabled'))
    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
    @if ($errors->has('g-recaptcha-response'))
        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
    @endif
    <script src="https://www.google.com/recaptcha/enterprise.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        grecaptcha.enterprise.ready(function () {
            grecaptcha.enterprise.execute('{{ config('services.recaptcha.site_key') }}', { action: '{{ $action ?? 'default' }}' }).then(function (token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script>
@endif

