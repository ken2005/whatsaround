@extends('layouts.app')
@section('content')
    <h1 style="text-align: center;" class="mb-4">Mes évenements</h1>
    @if (count($evenements) == 0)
    <p class="text-center no-following mb-4">Vous n'avez pas encore créé d'événement.</p>
    
    @endif
      <div class="events-container">
          @foreach ($evenements as $evenement)
          <a class="lien-discret" href="{{ route('evenement', ['id' => $evenement->id]) }}">
          <div class="event-card">
              <img src="../images/evenements/{{$evenement->image}}" alt="Événement" width="300" height="150">
              <h3>{{$evenement->nom}}</h3>
              <p>📍 {{$evenement->num_rue}} {{$evenement->allee}}, {{$evenement->ville}}</p>
              <p>📅 {{$evenement->date}}</p>
              <p>🕒 {{$evenement->heure}}</p>
          </div>
          </a>
          @endforeach
      </div>
@endsection
