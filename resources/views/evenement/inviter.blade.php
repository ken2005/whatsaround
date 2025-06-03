@extends('layouts.app')

@section('content')
<span id="inviter-utilisateurs">

    <div class="form-container">
        <h2 class="page-title">Inviter des utilisateurs</h2>
        <form action="{{route('evenement.doInviter', $evenement->id)}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="utilisateurs">Utilisateurs</label>
                <div class="select-container">
                    <div class="select-box">
                        <div class="search-box">
                            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher des utilisateurs...">
                        </div>
                        
                        <div class="checkbox-list">
                            @if (count($users) == 0)
                                <p class="no-users">Aucun utilisateur trouvé.</p>
                            @endif
                            @foreach($users as $user)
                            <div class="checkbox-item">
                                <label>
                                    <input type="checkbox" id="user_{{$user->id}}" name="users[]" value="{{$user->id}}" {{ is_array(old('users')) && in_array($user->id, old('users')) ? 'checked' : '' }}>
                                    <span class="user-name">{{$user->name}}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @error('users')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit">Inviter</button>
                <a href="{{route('evenement', $evenement->id)}}"><button type="button" class="back-button">Retour</button></a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let checkboxItems = document.querySelectorAll('.checkbox-item');
            
            checkboxItems.forEach(item => {
                let label = item.querySelector('label').textContent.toLowerCase();
                if (label.includes(searchText)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</span>

@endsection