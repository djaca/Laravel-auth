@if ($errors->has($input))
    <span class="help-block">
        <strong>{{ $errors->first($input) }}</strong>
    </span>
@endif