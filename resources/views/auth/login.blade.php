  <!DOCTYPE html>
  <html lang="fr">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>What's Around - Connexion</title>
      <style>
          * {
              margin: 0;
              padding: 0;
              box-sizing: border-box;
              font-family: 'Arial', sans-serif;
          }

          body {
              background-color: #f5f5f5;
          }

          header {
              background-color: #2c3e50;
              color: white;
              padding: 1rem;
              text-align: center;
          }

          .login-container {
              max-width: 400px;
              margin: 2rem auto;
              padding: 2rem;
              background-color: white;
              border-radius: 8px;
              box-shadow: 0 2px 4px rgba(0,0,0,0.1);
          }

          .form-group {
              margin-bottom: 1.5rem;
          }

          .form-group label {
              display: block;
              margin-bottom: 0.5rem;
              color: #2c3e50;
              font-weight: bold;
          }

          .form-group input {
              width: 100%;
              padding: 0.8rem;
              border: 1px solid #ddd;
              border-radius: 4px;
          }

          .form-group input:focus {
              outline: none;
              border-color: #3498db;
          }

          button {
              width: 100%;
              padding: 0.8rem 1.5rem;
              background-color: #3498db;
              color: white;
              border: none;
              border-radius: 4px;
              cursor: pointer;
              transition: background-color 0.3s;
          }

          button:hover {
              background-color: #2980b9;
          }

          .forgot-password {
              text-align: center;
              margin-top: 1rem;
          }

          .forgot-password a {
              color: #3498db;
              text-decoration: none;
          }

          .forgot-password a:hover {
              text-decoration: underline;
          }

          .register-link {
              text-align: center;
              margin-top: 1.5rem;
              color: #666;
          }

          .register-link a {
              color: #3498db;
              text-decoration: none;
          }

          .register-link a:hover {
              text-decoration: underline;
          }

          .error-message {
              color: #e74c3c;
              margin-top: 0.25rem;
              font-size: 0.875rem;
          }
      </style>
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
