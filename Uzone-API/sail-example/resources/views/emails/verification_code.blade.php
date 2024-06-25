<!DOCTYPE html>
<html>
<head>
    <title>認証コードの送信</title>
</head>
<body>
    <p>以下の認証コードを使用して、登録フォームに進んでください：</p>
    <p><strong>認証コード: {{ $verificationCode }}</strong></p>
    <p>登録フォームのリンク: <a href="{{ $registerUrl }}">{{ $registerUrl }}</a></p>
</body>
</html>

