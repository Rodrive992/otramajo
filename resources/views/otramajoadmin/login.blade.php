@extends('layouts.app')

@section('title','Ingresar – OtramaJo Admin')

@section('content')
<style>
:root{
    --om-blanco:#FAF9F6; --om-salvia:#A8C3A0; --om-rosa:#D4A8A1;
    --om-gris-claro:#D3D3D3; --om-arena:#F4E1A1; --om-carbon:#4A4A4A;
}
body{ background: var(--om-blanco); color: var(--om-carbon); }
.auth-card{
    max-width: 460px; margin: 8rem auto 3rem; background: var(--om-blanco);
    border:1px solid var(--om-gris-claro); border-radius: 1rem; padding: 2rem;
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
}
.btn-primary{
    display:inline-flex; align-items:center; justify-content:center;
    padding:.75rem 1rem; border-radius:.75rem; border:1px solid var(--om-gris-claro);
    background: linear-gradient(135deg, var(--om-rosa), var(--om-arena));
}
</style>

<div class="auth-card">
    <h1 class="om-brand text-3xl text-center mb-2">OtramaJo – Administrador</h1>
    <p class="text-center opacity-80 mb-6">Acceso para cargar contenidos</p>

    @error('email')
        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3">
            {{ $message }}
        </div>
    @enderror

    <form method="POST" action="{{ route('otramajoadmin.login.post') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
        </div>
        <div class="mb-4">
            <label class="block text-sm mb-1">Contraseña</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
        </div>
        <label class="inline-flex items-center gap-2 mb-4">
            <input type="checkbox" name="remember" class="border-gray-300"> <span>Recordarme</span>
        </label>
        <div>
            <button type="submit" class="btn-primary w-full">Ingresar</button>
        </div>
    </form>
</div>
@endsection
