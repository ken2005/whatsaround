@extends('layouts.app')
@section('content')
      <div class="search-container">
          <form action="{{ route('recherche') }}" method="GET">
          <div class="search-bar">
              <input type="text" placeholder="Rechercher par lieu, nom, date..." name="search">
              <button class="search-icon">🔍</button>
            </div>
        </form>
      </div>

      <div class="create-event">
        
        <a class="lien-discret" href="{{route('creer')}}">
            <button>Créer un événement</button>
        </a>
      </div>

      
        @if (array_count_values($evenementsAbonnements))
        <h2 class="text-center">Événements d'abonnements à venir</h2>
        <br>
        <div class="events-container">
            @foreach ($evenementsAbonnements as $evenement)
            <a class="lien-discret" href="{{ route('evenement', ['id' => $evenement->id]) }}">
                <div class="event-card">
                    <img src="./images/evenements/{{$evenement->image}}" alt="Événement" width="300" height="150">
                    <h3>{{$evenement->nom}}</h3>
                    <p>📍 {{$evenement->num_rue}} {{$evenement->allee}}, {{$evenement->ville}}</p>
                    <p>📅 {{$evenement->date}}</p>
                    <p>🕒 {{$evenement->heure}}</p>
                </div>
            </a>
            @endforeach
            </div>
            <br>
        @endif
        @if ($evenements->count() > 0)
        <h2 class="text-center">Événements à venir</h2>
        <br>
        <div class="events-container">

            @foreach ($evenements as $evenement)
            <a class="lien-discret" href="{{ route('evenement', ['id' => $evenement->id]) }}">
            <div class="event-card">
                <img src="./images/evenements/{{$evenement->image}}" alt="Événement" width="300" height="150">
                <h3>{{$evenement->nom}}</h3>
                <p>📍 {{$evenement->num_rue}} {{$evenement->allee}}, {{$evenement->ville}}</p>
                <p>📅 {{$evenement->date}}</p>
                <p>🕒 {{$evenement->heure}}</p>
            </div>
            
            </a>
            @endforeach
        </div>
            <br>
        @endif
          @if ($evenementsOld->count() > 0)
          <h2 class="text-center">Événements passés</h2>
          <br>
          <div class="events-container">

              @foreach ($evenementsOld as $evenement)
              <a class="lien-discret" href="{{ route('evenement', ['id' => $evenement->id]) }}">
              <div class="event-card">
                  <img src="./images/evenements/{{$evenement->image}}" alt="Événement" width="300" height="150">
                  <h3>{{$evenement->nom}}</h3>
                  <p>📍 {{$evenement->num_rue}} {{$evenement->allee}}, {{$evenement->ville}}</p>
                  <p>📅 {{$evenement->date}}</p>
                  <p>🕒 {{$evenement->heure}}</p>
              </div>
              </a>
              @endforeach
          </div>
          @endif
      </div>
 @endsection