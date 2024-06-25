<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証</title>
</head>
<body>
    <h1>メール認証</h1>

    <form action="{{ route('sendverificationcode') }}" method="POST">
        @csrf
        <table>
            <tr>
                <th>メールアドレス</th>
                <td>
                    <input type="email" name="user_email" required>
                </td>
            </tr>
        </table>
        <button type="submit">認証に進む</button>

    </form>
</body>
</html>
