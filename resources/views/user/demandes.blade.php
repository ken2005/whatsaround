@extends('layouts.app')

@section('content')
    <div class="profiles-container">
        @if($demandes->isEmpty())
            <p class="no-following">Aucune demande d'abonnement en attente</p>
        @else
            @foreach($demandes as $demande)
                <div class="profile-card">
                    <img src="./images/profils/{{$demande->follower->image}}" alt="Photo de profil" style="width: 100px; height: 100px; border-radius: 50%;">
                    <h3>{{ $demande->follower->name }}</h3>                    <div style="display: flex; gap: 10px;">
                        <form action="{{ route('demandes.accepter', $demande->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" style="background-color: #2ecc71;">Accepter</button>
                        </form>
                        <form action="{{ route('demandes.refuser', $demande->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" style="background-color: #e74c3c;">Refuser</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
