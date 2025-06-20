  @extends('layouts.app')

  @section('content')
  <span id="profil">

      <div class="profile-details">
              <div class="profile-info">
                  <img src="../images/profils/{{$user->image}}" alt="Photo de profil" class="profile-picture">
                  <h2>{{$user->name}}</h2>
                  <h3>{{$nbSuivi}} 
                      @if ($nbSuivi == 1)
                      
                      Abonné
                      @else
                      Abonnés
                      @endif
                  </h3><br>
                  <p>📧 Email: {{$user->email}}</p>
                  <p>📅 Membre depuis: {{$user->created_at->format('d/m/Y')}}</p>
              </div>

              <div class="profile-actions">
                  <a href="{{route('accueil')}}"><button class="back-button">Retour</button></a>
                  @if(auth()->id() !== $user->id)
                        @if($user->est_prive == 0 || $suivi)
                          <form action="{{ route($suivi ? 'seDesabonner' : 'suivre', $user->id) }}" method="POST">
                              @csrf
                              <button type="submit" class="follow-button">
                                  {{ $suivi ? 'Ne plus suivre' : 'Suivre' }}
                              </button>
                          </form>
                        @else
                            
                            <form action="{{ route($demande ? 'seDesabonner' : 'suivre'
                            , $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="{{ $demande ? 'back-button' : 'follow-button' }}">
                                    {{ $demande ? 'Demande envoyée' : 'Demander à suivre' }}
                                </button>
                            </form>
                        @endif
                    @else
                        @if($user->est_prive == 0)

                          <form action="{{ route('passerPrive', $user->id) }}" method="POST">
                              @csrf
                              <button type="submit" class="privacy-button">
                                  Passer en privé
                              </button>
                          </form>
                          @else

                          <form action="{{ route('passerPublic', $user->id) }}" method="POST">
                              @csrf
                              <button type="submit" class="privacy-button">
                                  Passer en public
                              </button>
                          </form>
                          @endif
                    @endif
                
              </div>
          </div>
      <div class="events-container">

      @if ($user->evenements->isEmpty())
      <p>{{$user->name}} n'a pas encore crée d'évenements</p>
      @endif
      @foreach ($user->evenements as $evenement)
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
  </span>

  @endsection