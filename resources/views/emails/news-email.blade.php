<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias do Dia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .news-item {
            margin-bottom: 20px;
        }
        .news-item a {
            color: #007BFF;
            text-decoration: none;
        }
        .news-item a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Últimas Notícias</h1>
        <p>Olá, veja abaixo as últimas notícias:</p>
        @foreach ($news as $item)
            <div class="news-item">
                <h3>{{ $item->title }}</h3>
                <p><a href="{{ $item->link }}" target="_blank">Leia mais</a></p>
            </div>
        @endforeach
        <p>Obrigado por acompanhar!</p>
    </div>
</body>
</html>
