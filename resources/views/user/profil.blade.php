  @extends('layouts.app')

  @section('content')
        <div class="profile-details">
                <div class="profile-info">
                    <img src="../images/profils/{{$user->image}}" alt="Photo de profil" class="profile-picture">
                    <h2>{{$user->name}}
                        @if ($user->badge_id == 2)
                        <i class="fa-solid fa-user-check"></i>
                        @elseif ($user->badge_id == 3)
                        <i class="fa-regular fa-circle-check"></i>
                        @elseif ($user->badge_id == 4)
                        <i class="fa-solid fa-check-to-slot"></i>                        @endif
                    </h2>
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
                          <form action="{{ route($suivi ? 'seDesabonner' : 'suivre', $user->id) }}" method="POST" style="display: inline;">
                              @csrf
                              <button type="submit" class="follow-button">
                                  {{ $suivi ? 'Ne plus suivre' : 'Suivre' }}
                              </button>
                          </form>
                          @else
                          @if($user->est_prive == 0)
                                                    <form action="{{ route('passerPrive', $user->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="privacy-button">
                                                            Passer en privé
                                                        </button>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('passerPublic', $user->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="privacy-button">
                                                            Passer en public
                                                        </button>
                                                    </form>
                                                    @endif
                          
                      @endif
                  
                </div>
            </div>
      
            <style>
                .profile-details {
                    max-width: 800px;
                    margin: 2rem auto;
                    padding: 2rem;
                    background-color: white;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
      
                .profile-info {
                    margin-bottom: 2rem;
                }
      
                .profile-info h2 {
                    color: #2c3e50;
                    margin-bottom: 1rem;
                    font-size: 2rem;
                }
      
                .profile-info p {
                    color: #666;
                    margin-bottom: 1rem;
                    font-size: 1.1rem;
                    line-height: 1.6;
                }
      
                .profile-actions {
                    display: flex;
                    gap: 1rem;
                    margin-top: 2rem;
                    flex-wrap: wrap;
                }
      
                .back-button {
                    background-color: #95a5a6;
                }
      
                .back-button:hover {
                    background-color: #7f8c8d;
                }

                .profile-picture {
                    width: 150px;
                    height: 150px;
                    border-radius: 50%;
                    object-fit: cover;
                    margin-bottom: 1rem;
                    border: 3px solid #3498db;
                }
            </style>
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

  @endsection