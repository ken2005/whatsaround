@extends('layouts.app')

@section('content')
<style>
    
</style>
<h1 class="mb-4" style="text-align: center;">Comptes suivis</h1>
@if(count($following) > 0)
<div class="profiles-container">
        @foreach($following as $user)
        <a href="{{ route('profil', ['id' => $user->id]) }}" class="lien-discret">
            <div class="profile-card">
                <img src="images/profils/{{$user->image}}" alt="Avatar" class="rounded" width="150" height="150">
                <h3>{{ $user->name }}</h3>
                <form action="{{ route('seDesabonner', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        Ne plus suivre
                    </button>
                </form>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <p class="text-center no-following mb-4">Vous ne suivez aucun compte pour le moment.</p>
    @endif
@endsection