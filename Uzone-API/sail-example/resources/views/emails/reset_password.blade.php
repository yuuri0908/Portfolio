<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <p>To reset your password, click the following link:</p>
    <p>
        <a href="{{ url('password/reset', $token) }}">
            Reset Password
        </a>
    </p>
</body>
</html>
