<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>EDIt VEt data!!</h1>
    <form action="/edit-vet/{{$vet->id}}" method="POST">
        @csrf
        @method('PUT')
        <input name="nombre" type="text" value={{ $vet->nombre }}><br>
        <input name="email" type="text" value={{ $vet->email }}><br>
        <!-- <input name="password" type="password" value="password"> -->
        <button>GuadrarCambios !!!</button>
    </form>
</body>
</html>