@extends('layouts.app')

@section('content')
    <span id="demandes">

        <div class="profiles-container">
            @if($demandes->isEmpty())
                <p class="no-following">Aucune demande d'abonnement en attente</p>
            @else
                @foreach($demandes as $demande)
                    <div class="profile-card">
                        <img src="./images/profils/{{$demande->follower->image}}" alt="Photo de profil" class="profile-img">
                        <h3>{{ $demande->follower->name }}</h3>                    
                        <div class="button-container">
                            <form action="{{ route('demandes.accepter', $demande->id) }}" method="POST" class="form-style">
                                @csrf
                                <button type="submit" class="accept-button">Accepter</button>
                            </form>
                            <form action="{{ route('demandes.refuser', $demande->id) }}" method="POST" class="form-style">
                                @csrf
                                <button type="submit" class="refuse-button">Refuser</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </span>
@endsection