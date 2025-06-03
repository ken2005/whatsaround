<!DOCTYPE html>
  <html lang="fr">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>What's Around</title>
    <link rel="stylesheet" href="{{ asset('app.css') }}">

      <!-- PWA -->
        <link rel="manifest" href="./manifest.json">
        <link rel="apple-touch-icon" href="icons/icon-512x512.png">
        <meta name="apple-mobile-web-app-capable" content="yes">

      
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  </head>
  <body>
      <header>
        <div class="header-content">
          <a class="lien-discret" href="{{route('accueil')}}"><h1>What's Around</h1></a>
          @guest
          <a class="lien-discret" href="{{route('connexion')}}"><button>Se connecter</button></a>
          @endguest
          @auth
          <div class="user-info">
                <span style="display: flex; align-items: center;">
                    <span class="pc-menu">
                        <a href="{{route('abonnements')}}" class="lien-discret"><i class="fa-solid fa-star {{ Route::currentRouteName() == 'abonnements' ? 'active-icon' : '' }}"></i></a>
                        <a href="{{route('evenements.inscriptions')}}" class="lien-discret"><i class="fa-solid fa-calendar-day {{ Route::currentRouteName() == 'evenements.inscriptions' ? 'active-icon' : '' }}"></i></a>
                        <a href="{{route('evenements.enregistres')}}" class="lien-discret"><i class="fa-solid fa-bookmark {{ Route::currentRouteName() == 'evenements.enregistres' ? 'active-icon' : '' }}"></i></a>
                        <a href="{{route('evenements.crees')}}" class="lien-discret"><i class="fa-solid fa-calendar-plus {{ Route::currentRouteName() == 'evenements.crees' ? 'active-icon' : '' }}"></i></a>
                        <a id="tkt" href="{{route('profil',['id' => auth()->user()->getAuthIdentifier()])}}" class="lien-discret"><i class="fas fa-user {{ Route::currentRouteName() == 'profil' ? 'active-icon' : '' }}"></i></a>
                    </span>
                    <span class="phone-menu">
                        <i class="fas fa-user profil"></i>
                    </span>
                </span>
                    <div class="user-menu">
                        <a href="{{route('profil',['id' => auth()->user()->getAuthIdentifier()])}}"><i class="fas fa-user-circle"></i> Profil</a>
                        <span class="phone-menu">
                        <a href="{{route('evenements.enregistres')}}"><i class="fa-solid fa-bookmark"></i> Evenements enregistrés</a>
                        <a href="{{route('evenements.inscriptions')}}"><i class="fa-solid fa-calendar-day"></i> Mes Inscriptions</a>
                        <a href="{{route('evenements.crees')}}"><i class="fa-solid fa-calendar-plus"></i> Mes Evenements</a>
                        <a href="{{route('abonnements')}}"><i class="fa-solid fa-star"></i> Mes Abonnements</a>
                        </span>
                        @if (auth()->user()->est_prive)
                        
                        <a href="{{ route('demandes') }}"><i class="fa-solid fa-user-plus"></i> Mes demandes d'abonnement</a>
                        @endif
                        <a href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a>
                    </div>
                </div>
                @endauth
            </div>
        </header>
        <div class="content">
          <div class="pull-to-refresh">
          <span>Chargement...</span>

        </div>
        @yield('content')
        </div>
        <script>
            document.getElementById('tkt').onmouseover = function() {
                document.querySelector('.user-menu').style.display = 'block';
            };
            document.querySelector('.user-menu').onmouseleave = function() {
                document.querySelector('.user-menu').style.display = 'none';
            };

            let lastScrollY = window.scrollY;

            window.addEventListener('scroll', () => {
                const header = document.querySelector('header');
                const currentScrollY = window.scrollY;

                if (currentScrollY > lastScrollY) {
                    // Scrolling down
                    header.classList.add('hidden');
                } else {
                    // Scrolling up or at top
                    header.classList.remove('hidden');
                }

                lastScrollY = currentScrollY;
            });
        </script>
        <script>
    const pullToRefresh = document.querySelector('.pull-to-refresh');
let touchstartY = 0;
document.addEventListener('touchstart', e => {
  touchstartY = e.touches[0].clientY;
});
document.addEventListener('touchmove', e => {
  const touchY = e.touches[0].clientY;
  const touchDiff = touchY - touchstartY;
  if (touchDiff > 0 && window.scrollY === 0) {
    pullToRefresh.classList.add('visible');
    e.preventDefault();
  }
});
document.addEventListener('touchend', e => {
  if (pullToRefresh.classList.contains('visible')) {
    pullToRefresh.classList.remove('visible');
    location.reload();
  }
});
  </script>
    </body>
</html>