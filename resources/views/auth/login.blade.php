@extends('layouts.login_layout')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white text-center">
        <h3 class="mb-0">Sistema de Compras</h3>
        <small>Inicie sesión para continuar</small>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Ingresar</button>
        </form>
    </div>
</div>
@endsection