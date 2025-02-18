@if ($errors->any())
    <div class="error-container">
        <strong>Whoops! Something went wrong.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<style>
    .error-container {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 12px;
        border-radius: 5px;
        margin-top: 10px;
    }
    .error-container ul {
        margin: 0;
        padding-left: 20px;
    }
    .error-container li {
        list-style-type: disc;
    }

</style>

