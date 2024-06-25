<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録確認</title>
</head>

<body>
    <h2>登録確認</h2>
    <form action="{{ route('register') }}" method="POST">
        @csrf
            <table>
                <tr>
                    <th>お名前</th>

                    <td>漢字:{{ $user_name }}</td>
                    <td>ひらがな:{{ $user_name }}</td>
                    <td>ローマ字:{{ $user_name }}</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $user_email }}</td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td>{{ $user_gender }}</td>
                </tr>
            </table>

            <p>上記でよろしければ確認ボタンを押してください</p>

            <buttun type="button" onclick="window.history.back()">戻る</buttun>
            <buttun type="submit">登録</buttun>
    </form>



</body>

</html>
