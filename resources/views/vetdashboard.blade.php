<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica Portal</title>
</head>
<body>
    <h1>Clinica Portal</h1>
    @auth('veterinaria')
    <p> Bienvenido, dashboard de la veterinaria: {{ Auth::guard('veterinaria')->user()->nombre }} </p>
    
    <!-- awg yeag! -->
    <div style="border: 3px solid black;"> 
        <h2> Registrar Veterinarios: </h2>
        <form action="/register-vet" method="POST">
        @csrf
        <input name="veterinaria_id" type="hidden" value={{ Auth::guard('veterinaria')->user()->id }}>
        <input name="nombre" type="text" placeholder="nombre de veterinario"><br>
        <input name="id" type="text" placeholder="CI del veterinario"><br>
        <input name="email" type="text" placeholder="correo electronico"><br>
        <input name="password" type="password" placeholder="password">
        <button type="submit">Registrar Veterinario</button>
        </form>
    </div>
    <br>
    <div style="border: 3px solid black;"> 
        @php
        $vets1 = \App\Models\Vet::where('veterinaria_id', Auth::guard('veterinaria')->user()->id)->get();
        @endphp
        @if($vets1->count() > 0)

        <h2> Sus veterinarios: </h2>
        @foreach($vets1 as $vet)
        <div style="background-color: gray; padding; 10px; margin: 10px;">
            <h3>Vet: {{$vet['nombre']}} ({{$vet['id']}}) de la veterinaria {{$vet->vetClinic->nombre}}, con codigo {{$vet->vetClinic->id}}</h3>
            <h3>Registrado en: {{$vet['created_at']}}</h3>
            <h3>email: {{$vet['email']}}</h3>
        
            <p><a href='/edit-vet/{{$vet->id}}' method='POST'>Editar datos de veterinario</a></p>
            <form action='/delete-vet/{{$vet->id}}' method='POST'>  
            @csrf
            @method('DELETE')
            <button>DELETE VETERINARIO</button>
            </form>
        </div>
        @endforeach
    </div>
    @else
    <p>No hay veterinarios registrados.</p>
    @endif
    
    <form action="/clinilogout" method="POST">
        @csrf
        <button>Logout :3</button>
    </form>

    @else
    <div style="border: 3px solid black;"> 
        <h2> Register </h2>
        <form action="/registerclinic" method="POST">
        @csrf
        <input name="id" type="number" placeholder="codigo"><br>
        <input name="nombre" type="text" placeholder="nombre"><br>
        <input name="telf" type="number" placeholder="numero telefonico"><br>
        <input name="email" type="text" placeholder="email"><br>
        <input name="direccion" type="text" placeholder="direccion"><br>
        Tipo de veterinaria:<br>
        <input type="radio" name="tipo" value="clinica" id="clinica">
        <label for="clinica">Clinica</label><br>
        <input type="radio" name="tipo" value="consultorio" id="consultorio">
        <label for="consultorio">Consultorio</label><br>
        <input name="password" type="password" placeholder="password"><br>
        <button>Register</button>
        </form>
    </div>
    
    <div style="border: 3px solid black;"> 
        <h2> LogIn </h2>
        <form action="/loginclinic" method="POST">
        @csrf
        <input name="id" type="number" placeholder="codigo">
        <input name="loginpassword" type="password" placeholder="password">
        <button>Log in</button>
        </form>
    </div>
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
    @endauth
</body>
</html>
