@extends('layouts.app')

@section('content')
    <div class="form-container">
        <h2 style="margin-bottom: 1.5rem; color: #2c3e50;">Inviter des utilisateurs</h2>
        <form action="{{route('evenement.doInviter', $evenement->id)}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="utilisateurs">Utilisateurs</label>
                <div style="width: 300px;">
                    <div style="border: 1px solid #ccc; border-radius: 4px;width: 90%;">
                        <div style="padding: 8px; border-bottom: 1px solid #ccc;">
                            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher des utilisateurs...">
                        </div>
                        
                        <div class="checkbox-list" style="height: 200px; overflow-y: auto; padding: 8px;">
                            @if (count($users) == 0)
                                <p style="text-align: center;">Aucun utilisateur trouvé.</p>
                            @endif
                            @foreach($users as $user)
                            <div class="checkbox-item">
                                <label style="display: flex; align-items: center;">
                                    <input type="checkbox" id="user_{{$user->id}}" name="users[]" value="{{$user->id}}" {{ is_array(old('users')) && in_array($user->id, old('users')) ? 'checked' : '' }}>
                                    <span style="margin-left: 8px;">{{$user->name}}</span>
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

    <style>
        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: bold;
        }

        .form-control {
            padding: 8px;
            border: none;
            width: 100%;
            outline: none;
        }

        .checkbox-item {
            padding: 4px 0;
        }

        .checkbox-item label {
            margin-left: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .checkbox-item input[type="checkbox"] {
            cursor: pointer;
            margin: 0;
        }

        .text-danger {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
        }

        .button-group button {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-button {
            background-color: #2c3e50;
            color: white;
            border: none;
        }

        .back-button:hover {
            background-color: #34495e;
        }
    </style>
@endsection
