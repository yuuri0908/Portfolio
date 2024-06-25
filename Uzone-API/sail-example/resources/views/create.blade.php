<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人会員登録</title>
</head>

<body>
    <h1>会員登録</h1>
    <form action="{{ route('requests.confirm') }}" method="POST">
        @csrf
        <table>
            <tr>
                <th>お名前</th>
                    <td>
                        <h2>漢字入力</h2>
                            <label for="kanji_last_name">姓 (Last Name) 漢字:</label>
                            <input type="text" id="kanji_last_name" name="kanji_last_name" required pattern="[\u4E00-\u9FFF\u3400-\u4DBF]+" title="漢字のみを入力してください">

                            <label for="kanji_first_name">名 (First Name) 漢字:</label>
                            <input type="text" id="kanji_first_name" name="kanji_first_name" required pattern="[\u4E00-\u9FFF\u3400-\u4DBF]+" title="漢字のみを入力してください">

                        <h2>ひらがな入力</h2>
                            <label for="hiragana_last_name">姓 (Last Name) ひらがな:</label>
                            <input type="text" id="hiragana_last_name" name="hiragana_last_name" required pattern="[\u3040-\u309F]+" title="ひらがなのみを入力してください">

                            <label for="hiragana_first_name">名 (First Name) ひらがな:</label>
                            <input type="text" id="hiragana_first_name" name="hiragana_first_name" required pattern="[\u3040-\u309F]+" title="ひらがなのみを入力してください">

                        <h2>ローマ字入力</h2>
                            <label for="roman_last_name">姓 (Last Name) ローマ字:</label>
                            <input type="text" id="roman_last_name" name="roman_last_name" required pattern="[A-Za-z\s]+" title="ローマ字のみを入力してください">

                            <label for="roman_first_name">名 (First Name) ローマ字:</label>
                            <input type="text" id="roman_first_name" name="roman_first_name" required pattern="[A-Za-z\s]+" title="ローマ字のみを入力してください">

                    </td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>
                    <input type="text" name="user_email">
                </td>
            </tr>
            <tr>
                <th>メールアドレス（確認）</th>
                <td>
                    <input type="email" name="user_email_confirmation" required>
                </td>
            </tr>
            <tr>
                <th>性別</th>
                <td>
                    <input type="radio" name="user_gender" value="男性" checked>男性
                    <input type="radio" name="user_gender" value="女性">女性
                    <input type="radio" name="user_gender" value="その他" checked>回答しない
                </td>
            </tr>
        </table>
        <button type="submit">確認へ進む</button>

    </form>
</body>

</html>

