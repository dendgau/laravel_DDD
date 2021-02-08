<form method="POST" action="{{ route('blog_update') }}">
    {{ csrf_field() }}
    <input type="text" name="title" value="{{ $title ?? old('title') }}">
    <input type="content" name="content" value="{{ $content ?? old('content') }}">
    <input type="submit" name="btnSubmit" />
</form>
