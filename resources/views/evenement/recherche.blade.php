@extends('layouts.app')
@section('content')
<div class="search-container">
    <form action="{{ route('recherche') }}" method="GET">
          <div class="search-bar">
              <input name="search" type="text" placeholder="Rechercher par lieu...">
              <button class="search-icon">🔍</button>
            </div>
        </form>
        </div>

      <div class="create-event">
        <a class="lien-discret" href="{{route('creer')}}">
            <button>Créer un événement</button>
        </a>
      </div>

      <h2 style="text-align: center;">Evenements</h2>
      <div class="events-container">
        @if (count($evenements) == 0)
        <p>Aucun événement trouvé.</p>
        @endif
          @foreach ($evenements as $evenement)
          <a class="lien-discret" href="{{ route('evenement', ['id' => $evenement->id]) }}">
          <div class="event-card">
              <img src="./images/evenements/{{$evenement->image}}" alt="Événement" width="300" height="150">
              <h3>{{$evenement->nom}}</h3>
              <p>📍 {{$evenement->num_rue}} {{$evenement->allee}}, {{$evenement->ville}} {{$evenement->code_postal}}, {{$evenement->pays}}</p>
              <p>📅 {{$evenement->date}}</p>
              <p>🕒 {{$evenement->heure}}</p>
          </div>
          </a>
          @endforeach
      </div>

      <h2 style="text-align: center;">Profils</h2>
      <div class="profiles-container">
        @if (count($users) == 0)
        <p>Aucun profil trouvé.</p>
        @endif
          @foreach ($users as $profil)
          <a class="lien-discret" href="{{ route('profil', ['id' => $profil->id]) }}">
          <div class="profile-card">
              <img src="images/profils/{{$profil->image}}" alt="Photo de profil" width="100" height="100">
              <h3>{{$profil->name}}</h3>
              <p>{{$profil->description}}</p>
          </div>
          </a>
          @endforeach
      </div>
 @endsection