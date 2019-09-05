<form action="{!! route('save') !!}" method="post" class="form-horizontal" style="margin-bottom: 50px;">
    {!! csrf_field() !!}

    <div class="alert alert-error hide">
        Сообщение не может быть пустым
    </div>

    <div class="control-group">
                <textarea name="text" style="width: 100%; height: 50px;" type="password" id="inputText"
                          placeholder="Ваше сообщение..."
                          data-cip-id="inputText"></textarea>
    </div>
    <div class="control-group">
        <button type="submit" class="btn btn-primary">Отправить сообщение</button>
    </div>
</form>