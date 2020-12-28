<form method="POST" action="{{ route('auth_logout') }}">
    {{ csrf_field() }}
    <input type="hidden" name="logout" value="1"/>
    <input type="submit" name="btnLogout" />
</form>