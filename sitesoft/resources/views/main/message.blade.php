<div class="well js-message-block" data-message_id="{{ isset($message) ? $message->id : '' }}">
    <h5 class="js-message-user-name">{{ isset($message) ? $message->user->name : '' }}:</h5>
    <h6 class="js-message-created-at">{{ isset($message) ? $message->created_at->format('d.m.Y H:i:s') : '' }}</h6>
    <div class="js-message-text">
        {{ isset($message) ? $message->text : '' }}
    </div>
</div>
