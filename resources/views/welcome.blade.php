<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>csvアップロード</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- CSSを追加 -->
</head>
<body class="bg-gray-100 p-4">
    <div id="app">
        <example-component></example-component>
        <csv-uploader></csv-uploader>
    </div>
</body>
</html>