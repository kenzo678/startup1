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
    
    <div style="border: 3px solid black;"> 
        <h2> Registrar Visita: </h2>
        <form action="/register-trat" method="POST">
        @csrf
        <input name="pet_id" type="number" placeholder="id de mascota"><br>
        <input name="veterinarian_id" type="hidden" value={{ Auth::guard('vet')->user()->id }}>
        <input name="title" type="text" placeholder="titulo"><br>
        <input name="description" type="text" placeholder="descripcion"><br>
        <input name="treatment_date" type="date" value="{{ now()->toDateString() }}"><br>
        <input name="checkup_date" type="date" value="{{ now()->addMonths(6)->toDateString() }}"><br>

        <button type="submit">Registrar Visita</button>
        </form>
    </div>
    <br>

    <div style="border: 3px solid black;"> 
        @php
        $visits1 = \App\Models\Pet_tratamiento::where('veterinarian_id', Auth::guard('vet')->user()->id)->get();
        //$visits1 = DB::table('pet_tratamientos')->where('pet_id', Auth::guard('vet')->user()->id)->get();
        @endphp
        @if($visits1->count() > 0)

        <h2> Sus visitas: </h2>
        @foreach($visits1 as $vst)
        <div style="background-color: gray; padding; 10px; margin: 10px;">
            <h2>Mascota: {{$vst->pet->nombre}}, Veterinario: {{$vst->vet->nombre}}</h2>
            <h3>Fecha: {{$vst['treatment_date']}} Retorno: {{$vst['checkup_date']}}</h3>
            <h3>Titulo: {{$vst['title']}}</h3>
            <h3>descripcion: {{$vst['description']}}</h3>
        
            <p><a href='/edit-trat/{{$vst->id}}' method='POST'>Editar datos de visita.</a></p>
            <form action='/delete-trat/{{$vst->id}}' method='POST'>  
            @csrf
            @method('DELETE')
            <button>DELETE REGISTRO DE VISITA</button>
            </form>
        </div>
        @endforeach
    </div>
    @else
    <p>No hay visitas registradas.</p>
    @endif
    
    <form action="/logoutvet" method="POST">
        @csrf
        <button>Logout :3</button>
    </form>

    @else
    
    <div style="border: 3px solid black;"> 
        <h2> LogIn </h2>
        <form action="/loginvet" method="POST">
        @csrf
        <!-- <input name="vetid" type="number" placeholder="ID de veterinaria"> -->
        <input name="CI" type="text" placeholder="CI">
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