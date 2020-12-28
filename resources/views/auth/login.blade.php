<form method="POST" action="{{ route('auth_authenticate') }}">
    {{ csrf_field() }}
    <input type="text" name="email" value="root@ddd-frontweb-local.com">
    <input type="password" name="password" value="root">
    <input type="submit" name="btnSubmit" />
</form>