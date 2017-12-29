<!DOCTYPE html>
<html>
<head>
    <title>登入</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="moniAdminLogin">
        <moni-admin-login></moni-admin-login>

    </div>
<script>

</script>


<script src="{{ asset('admin/js/login.js') }}"></script>
</body>
</html>