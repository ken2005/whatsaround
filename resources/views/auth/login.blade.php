  <!DOCTYPE html>
  <html lang="fr" id="auth-page">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>What's Around - Connexion</title>
      <link rel="stylesheet" href="{{ asset('style.css') }}">
  </head>
  <body>
      <header>
          <h1>What's Around</h1>
      </header>

      <div class="login-container">
          <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="form-group">
                  <label for="email">Adresse e-mail</label>
                  <input type="email" id="email" name="email" required autofocus value="{{ old('email') }}">
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

              <input type="checkbox" name="remember" id="remember">
            <label for="remember">Se souvenir de moi</label><br><br>
              <div class="form-group">
                  <button type="submit">Se connecter</button>
              </div>

            
              <div class="forgot-password">
                  <a href="">Mot de passe oublié ?</a>
              </div>
    

              <div class="register-link">
                  Pas encore de compte ? <a href="{{route('inscription')}}">S'inscrire</a>
              </div>
          </form>
      </div>
  </body>
  </html>
