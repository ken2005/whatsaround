
<!DOCTYPE html>
<html lang="fr" id="auth-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What's Around - Inscription</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        
    </style>
</head>
<body>
    <header>
        <h1>What's Around</h1>
    </header>

    <div class="login-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" required autofocus value="{{ old('name') }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <button type="submit">S'inscrire</button>
            </div>

            <div class="login-link">
                Déjà inscrit ? <a href="{{ route('connexion') }}">Se connecter</a>
            </div>
        </form>
    </div>
</body>
</html>
