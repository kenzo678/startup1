<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETSVETS</title>
</head>
<body>
    <h1> PETSVETS </h1>
    <h2> Veterinarios. </h2>
    @auth('vet')
    <p> Bienvenido, veterinario {{ Auth::guard('vet')->user()->nombre }} </p>
    <form action="/logout" method="POST">
        @csrf
        <button>Logout :3</button>
    </form>

    @else
    <!-- -- >
    <div style="border: 3px solid black;"> 
        <h2> Register </h2>
        <form action="/registervet" method="POST">
        @csrf
        <input name="nombre" type="text" placeholder="nombre">
        <input name="veterinaria" type="hidden" placeholder="veterinaria">
        <input name="email" type="text" placeholder="email">
        <input name="password" type="password" placeholder="password">
        <button>Register</button>
        </form>
    </div>
    <! -- -->
    
    <div style="border: 3px solid black;"> 
        <h2> LogIn </h2>
        <form action="/loginvet" method="POST">
        @csrf
        <input name="vetid" type="text" placeholder="ID de veterinaria">
        <input name="loginname" type="text" placeholder="nombre">
        <input name="loginpassword" type="password" placeholder="password">
        <button>Log in</button>
        </form>
    </div>
        
    @endauth



</body>
</html>