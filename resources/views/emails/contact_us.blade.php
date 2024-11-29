<p> {{ $name }} has contacted you via Contact Us form. </p>

<p> <b> Name: {{ $name }} </b> </p>
<p> <b> Email: {{ $email }} </b> </p>
<p> <b> Phone: {{ $phone }} </b> </p>
<br>
<h3> <b> Subject: </b> </h3>
<p> {{ $subject }} </p>
<h3> <b> Message: </b> </h3>
<p> {{ $msg }} </p>

<p> <a href="{{ URL::route('index') }}">logistiQuote Team</a> </p>