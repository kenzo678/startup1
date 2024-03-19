<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>EDItar Tratamiento</h1>
    <form action="/edit-trat/{{$trt->id}}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="titulo" value="{{$trt->titulo}}">
        <textarea name="desc">{{$trt->desc}}</textarea>
        <button>GuadrarCambios !!!</button>
    </form>
</body>
</html>