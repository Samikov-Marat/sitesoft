
@foreach($messages as $message)
    <div class="well">
        <h5>{{ $message->user->name }}:</h5>
        <h6>{{ $message->created_at->format('d.m.Y H:i:s') }}</h6>
        {{ $message->text }}
    </div>
@endforeach
