<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div style="font-family: 'Segoe UI';">
    <h2>{{$titulo}}</h2>
    <p>Olá <span style="font-weight: bold;">{{$name}}</span>,</p>
    <p>Para redefinir sua senha, por favor <a href="{{$url_token}}">Clique aqui</a>.</p>
    <p>Este link irá expirar em {{$time_token}} minutos.</p>
    <p><br></p>
    <p>Para mais detalhes acesse seu painel administrativo:</p>
    <a href="{{$url_site}}" target="_blank">
        <p>Painel Administrativo</p>
        <p><img src='http://medisom.com.br/public/uploads/LogoMedisom128px.png'/></p>
    </a>
</div>
</body>
</html>