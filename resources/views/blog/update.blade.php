<form method="POST" action="{{ route('blog_update', ['id' => request('id')]) }}">
    {{ csrf_field() }}
    <input type="text" name="title" value="{{ $title ?? old('title') }}">
    <input type="content" name="content" value="{{ $content ?? old('content') }}">
    <input type="submit" name="btnSubmit" value="Update"/>
</form>

<form method="POST" action="{{ route('blog_destroy', ['id' => request('id')]) }}">
    {{ csrf_field() }}
    <input type="submit" name="btnDelete" value="Delete"/>
</form>
