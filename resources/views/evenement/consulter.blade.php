  @extends('layouts.app')

  @section('content')
  <span id="consulter-evenement">

    <div class="event-details">
        <div class="image-container">
            <img src="../images/evenements/{{$evenement->image}}" alt="Événement" class="event-image">
        </div>
    
        <div class="event-info">
            <h2>{{$evenement->nom}}
            @if ($evenement->diffusion_id == 2)
            <i class="fa-solid fa-lock"></i>
            @elseif ($evenement->diffusion_id == 3)
            <i class="fa-solid fa-street-view"></i>
            @endif
            </h2>
            <h4> Catégories : 
            @if (count($evenement->categories) > 0)
                @foreach ($evenement->categories as $categorie)
                    {{$categorie->libelle}}
                    @if(!$loop->last)
                    ,
                    @endif

                
                @endforeach
            @endif
            </h4><br>
            <p>📍 {{$evenement->num_rue}} {{$evenement->allee}}, {{$evenement->ville}} {{$evenement->code_postal}}, {{$evenement->pays}}</p>
            <p>📅 {{$date}}</p>
            <p>🕒 {{$evenement->heure}}</p>
            <p>
            @if ($evenement->annonciateur)
            📢 Annonciateur:
            @else
            👥 Organisateur: 
            @endif
            <a class="lien" href="{{route('profil', ['id' => $evenement->user->id])}}">
                {{$evenement->user->name}}
            </a>
            @if ($editeurs->count() > 0)
            <br>📝 Éditeurs:
                @foreach ($editeurs as $editeur)
                    <a class="lien" href="{{route('profil', ['id' => $editeur->id])}}">
                        {{$editeur->name}}
                    </a>
                    @if(!$loop->last)
                    ,
                    @endif
                @endforeach
            @endif
            </p>
            <p>📝 Description: {{$evenement->description}}</p>
            <p>👥 
                <a class="lien" href="{{route('evenement.participants', ['id' => $evenement->id])}}">
            {{$nbParticipants}}
            @if ($evenement->max_participants != null)
            / {{$evenement->max_participants}}
            @endif
            participants
            </a>
            </p>
            @if (!$participantsSuivis->isEmpty())
            @foreach ($participantsSuivis as $participant)
                    @if($loop->last && $participantsSuivis->count() > 1)
                            et
                    @endif
                    {{$participant->name}}
                    @if(!$loop->last)
                    ,
                    @endif
            @endforeach
            
            @if ($participantsSuivis->count() == 1)
            participe à l'événement.
            @else 
            participent à l'événement.
            @endif
            @endif
            
        </div>

        <div class="event-actions">
            <a href="{{route('accueil')}}"><button class="back-button">Retour</button></a>
            @if (!$inscrit)
            @if ($evenement->max_participants == null || $nbParticipants < $evenement->max_participants)
            
            <form action="{{ route('sInscrire', ['id' => $evenement->id]) }}" method="POST">
                @csrf
                <button>Participer à l'événement</button>
            </form>
            @endif
            @else
            <form action="{{ route('seDesinscrire', ['id' => $evenement->id]) }}" method="POST">
            @csrf
            <button>Se désinscrire de l'événement</button>
            </form>
            @endif
            @if (!$enregistre)
            <form action="{{ route('enregistrer', ['id' => $evenement->id]) }}" method="POST">
                @csrf
                <button type="submit">Enregistrer l'événement</button>
            </form>
            @else
            <form action="{{ route('desenregistrer', ['id' => $evenement->id]) }}" method="POST">
            @csrf
            <button type="submit">Désenregistrer l'événement</button>
            </form>
            @endif
            @if ($owned)
            <a href="{{ route('evenement.inviter', ['id' => $evenement->id]) }}">
                
                <button type="submit">inviter des utilisateurs</button>
            </a>
            <form action="{{ route('evenement.supprimer', ['id' => $evenement->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Supprimer l'événement</button>
            </form>
            @endif
            @if ($owned || $editeur)
            <a href="{{ route('evenement.modifier', ['id' => $evenement->id]) }}">
                <button type="submit">Éditer l'événement</button>
            </a>
            @endif
        </div>


    </div>
  </span>

  @endsection