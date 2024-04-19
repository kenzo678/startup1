<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETSVETS</title>
</head>
<body>
    <h1> PETSVETS </h1>
    <h2> Users </h2>
    @auth
    <p> Bienvenido, {{ Auth::user()->nombre }} </p>

    <!--pets-->
    <div style="border: 3px solid black;"> 
        <h2> Registrar Mascota: </h2>
        <form action="/register-pet" method="POST">
        @csrf
        <input name="nombre" type="text" placeholder="nombre de mascota"><br>
        <input name="especie" type="text" placeholder="especie de mascota"><br>
        <select name="sexo" required>
            <option value="m">Macho</option>
            <option value="f">Hembra</option>
        </select><br>
        <input name="peso" type="number" step="0.01" placeholder="Peso de la mascota" required><br>
        <textarea name="observaciones" placeholder="Observaciones sobre la mascota"></textarea><br>
        <button type="submit">Registrar Mascota</button>
        </form>
    </div>
    <br>
    <div style="border: 3px solid black;"> 
        @php
        $pets1 = \App\Models\Pet::where('user_id', Auth::user()->id)->get();
        @endphp
        @if($pets1->count() > 0)

        <h2> Sus mascotas: </h2>
        @foreach($pets as $pet)
        <div style="background-color: gray; padding; 10px; margin: 10px;">
            <h3>{{$pet['nombre']}} de {{$pet->petUser->nombre}}</h3>
            <h3>Especie: {{$pet['especie']}}</h3>
            <h3>Sexo: {{$pet['sexo']}}</h3>
            <h3>Peso: {{$pet['peso']}}</h3>
            <h3>Observaciones: </h3>
            {{$pet['observaciones']}}
            <br>
            <div style="border: 3px solid black; background-color: light-gray; padding; 10px; margin: 10px;">
                <h2>Tratamientos:</h2>
                @php
                // $treatments = DB::table('visits')->where('pet_id', $pet->id)->get();
                $treatments = \App\Models\Pet_tratamiento::where('pet_id', $pet->id)->get();
                //Log::info('Pets found for user: ', ['pets' => $pets]);
                //Log::info('Pet 1 found for user: ', ['pet' => $pets[0]['nombre']]);
                //Log::info('Pet 1s owner found for user: ', ['user' => $pets[0]->petUser]);
                @endphp
                    @if($treatments->count() > 0)
                @foreach($treatments as $vst)
                <h3>Veterinario: {{$vst->vet->nombre}}</h3>
                <h3>Fecha: {{$vst['treatment_date']}} Retorno: {{$vst['checkup_date']}}</h3>
                <h3>Titulo: {{$vst['title']}}</h3>
                <h3>descripcion: {{$vst['description']}}</h3>

                @endforeach
                    @else
                        <p>No hay tratamientos registrados para esta mascota.</p>
                    @endif
            <br>

            </div>
            <br>
            <p><a href='/edit-pet/{{$pet->id}}' method='POST'>Editar datos Mascota</a></p>
            <form action='/delete-pet/{{$pet->id}}' method='POST'>  
            @csrf
            @method('DELETE')
            <button>DELETE MASCOTA</button>
            </form>
        </div>
        @endforeach
    </div>
    @else
    <p>No hay mascotas registradas.</p>
    @endif

    <form action="/logout" method="POST">
        @csrf
        <button>Logout :3</button>
    </form>

    @else
    <div style="border: 3px solid black;"> 
        <h2> Register </h2>
        <form action="/register" method="POST">
        @csrf
        <input name="nombre" type="text" placeholder="nombre"><br>
        <input name="email" type="text" placeholder="email"><br>
        <input name="telf" type="number" placeholder="numero telefonico"><br>
        <input name="password" type="password" placeholder="password"><br>
        <button>Register</button>
        </form>
    </div>
    
    <div style="border: 3px solid black;"> 
        <h2> LogIn </h2>
        <form action="/login" method="POST">
        @csrf
        <input name="loginname" type="text" placeholder="nombre">
        <input name="loginpassword" type="password" placeholder="password">
        <button>Log in</button>
        </form>
    </div>
        
    @endauth



</body>
</html>