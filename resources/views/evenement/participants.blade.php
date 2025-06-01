@extends('layouts.app')

@section('content')
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

    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('evenement', $evenement->id) }}" class="lien-discret"><button>Revenir à l'événement</button></a>
    </div>
</div>

<style>
.content .participants-list {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.content .participant-card {
    background: white;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.content .participant-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.content .participant-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.content .participant-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

.content .participant-details {
    flex-grow: 1;
}

.content .participant-details h3 {
    margin: 0;
    color: #333;
    font-size: 1.2rem;
}

.content .inscription-date {
    color: #666;
    font-size: 0.9rem;
    margin: 5px 0 0 0;
}

.content .no-participants {
    text-align: center;
    color: #666;
    font-style: italic;
    padding: 20px;
}

.content h1 {
    color: #2c3e50;
    font-weight: bold;
    margin-bottom: 30px;
}

.return-button {
    padding: 10px 20px;
    font-size: 1.1rem;
    font-weight: 500;
    border-radius: 25px;
    transition: all 0.3s ease;
    background-color: #6c757d;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.return-button:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.15);
}
</style>
@endsection