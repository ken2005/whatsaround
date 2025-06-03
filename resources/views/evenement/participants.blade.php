@extends('layouts.app')

@section('content')
<span id="participants">

    <div class="container">
        <h1 style="text-align: center;" class="text-center mb-4">Participants à l'événement "{{ $evenement->nom }}"</h1>
    
        <div class="participants-list">
            @if($evenement->inscriptions->count() > 0)
                @foreach($evenement->inscriptions as $inscription)
                <a class="lien-discret" href="{{ route('profil', ['id' => $inscription->id]) }}">
                    <div class="participant-card">
                        <div class="participant-info">
                            <img src="{{ asset('images/profils/' . ($inscription->image ?? 'default.jpg')) }}" 
                                 alt="Photo de profil" 
                                 class="participant-avatar">
                            <div class="participant-details">
                                <h3>{{ $inscription->name }}</h3>
                                <p class="inscription-date">Inscrit le {{ $inscription->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            @else
                <p class="no-participants">Aucun participant inscrit pour le moment.</p>
            @endif
        </div>
    
        <div class="text-center mt-4">
            <a href="{{ route('evenement', $evenement->id) }}" class="lien-discret"><button>Revenir à l'événement</button></a>
        </div>
    </div>
</span>

@endsection