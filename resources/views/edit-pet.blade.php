<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>EDIt PEt data!!</h1>
    <form action="/edit-pet/{{$pet->id}}" method="POST">
        @csrf
        @method('PUT')
        <h4>Datos de <b>{{$pet['nombre']}}</b></h4>
        <input name="peso" type="number" step="0.01" value={{ $pet->peso }} required><br>
        <textarea name="observaciones">{{$pet->observaciones}}</textarea><br>
        <button>GuadrarCambios !!!</button>
    </form>
</body>
</html>