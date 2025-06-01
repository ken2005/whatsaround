<!DOCTYPE html>
  <html lang="fr">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>What's Around</title>
      <style>
          * {
              margin: 0;
              padding: 0;
              box-sizing: border-box;
              font-family: 'Arial', sans-serif;
              
          }

          .lien-discret {
                all: unset;
            cursor: pointer;
            }

          body {
              background-color: #f5f5f5;
          }

          body {
        overscroll-behavior-y: auto;
      }
      .pull-to-refresh {
        position: fixed;
        top: -50px;
        width: 100%;
        height: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: top 0.7s ease-in-out;
      }
      .pull-to-refresh.visible {
        top: 0;
      }

          header {
              background-color: #2c3e50;
              color: white;
              padding:  1rem 1rem 0.8rem 1rem;
              text-align: center;
              position: fixed;
              width: 100%;
              top: 0;
              z-index: 1000;
              transition: transform 0.3s ease-in-out;
          }

          header.hidden {
              transform: translateY(-100%);
          }

          .header-content {
              max-width: 800px;
              margin: 0 auto;
              display: flex;
              justify-content: space-between;
              align-items: center;
          }

          .content {
              margin-top: 80px;
          }

          .search-container {
              max-width: 800px;
              margin: 2rem auto;
              padding: 1rem;
              background-color: white;
              border-radius: 8px;
              box-shadow: 0 2px 4px rgba(0,0,0,0.1);
          }

          .search-bar {
              display: flex;
              gap: 1rem;
              padding: 1rem;
              position: relative;
          }

          input[type="text"] {
              flex: 1;
              padding: 0.8rem;
              padding-right: 40px;
              border: 1px solid #ddd;
              border-radius: 4px;
          }

          .search-icon {
              position: absolute;
              right: 25px;
              top: 50%;
              transform: translateY(-50%);
              font-size: 20px;
              color: #3498db;
              cursor: pointer;
              background: none;
              border: none;
              padding: 0;
          }

          .search-icon:hover {
              color: #2980b9;
          }

          button {
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

          .create-event {
              text-align: center;
              margin: 2rem;
          }

          .events-container, .profiles-container {
              max-width: 800px;
              margin: 0 auto;
              padding: 1rem;
              display: grid;
              grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
              gap: 1rem;
          }

          .event-card {
              background-color: white;
              border-radius: 8px;
              padding: 1rem;
              box-shadow: 0 2px 4px rgba(0,0,0,0.1);
          }

          .event-card img {
              width: 100%;
              height: 150px;
              object-fit: cover;
              border-radius: 4px;
          }

          .event-card h3 {
              margin: 1rem 0;
              color: #2c3e50;
          }

          .event-card p {
              color: #666;
              margin-bottom: 0.5rem;
          }

          .user-info {
              position: relative;
              cursor: pointer;
          }

          .user-info i {
              font-size: 24px;
              margin: 0 15px;
              height: 2rem;
          }

          .user-menu {
              display: none;
              position: absolute;
              top: 100%;
              right: 0;
              background-color: white;
              border-radius: 8px;
              box-shadow: 0 4px 8px rgba(0,0,0,0.2);
              min-width: fit-content;
              white-space: nowrap;
              z-index: 10;
              padding: 8px 0;
              margin-top: 10px;
          }

          .user-menu::before {
              content: '';
              position: absolute;
              top: -8px;
              right: 28px;
              width: 0;
              height: 0;
              border-left: 8px solid transparent;
              border-right: 8px solid transparent;
              border-bottom: 8px solid white;
          }

          .user-menu a {
              display: block;
              padding: 12px 20px;
              color: #2c3e50;
              text-decoration: none;
              transition: background-color 0.2s, color 0.2s;
              text-align: left;
          }

          .user-menu a:hover {
              background-color: #f8f9fa;
              color: #3498db;
          }

          .profile-card {
              background: #fff;
              border-radius: 10px;
              padding: 20px;
              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
              text-align: center;
              transition: transform 0.3s ease;
          }
          .profile-card img {
              object-fit: cover;
              margin-bottom: 15px;
              border: 3px solid #f8f9fa;
          }
          .profile-card h3 {
              color: #333;
              margin-bottom: 15px;
          }
          .profile-card button {
              width: 100%;
              transition: all 0.3s ease;
          }
          .no-following {
              color: #666;
              font-size: 1.2rem;
              width: 100%;
          }

          
          .lien-discret {
              text-decoration: none;
              color: inherit;
          }

          .lien-discret {
                all: unset;
            cursor: pointer;

            }

            .lien-discret, nav a, div, button{
                -webkit-tap-highlight-color: transparent;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .lien-discret:focus, nav a:focus, div:focus, button:focus{
                outline: none !important;
            }

          .active-icon {
              border-bottom: 2px solid white;
          }

          .phone-menu {
              display: none;
          }

          @media screen and (max-width: 768px) {
            *{scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none;  /* IE 10+ */

  &::-webkit-scrollbar {
    background: transparent; /* Chrome/Safari/Webkit */
    width: 0px;}
              .pc-menu {
                  display: none;
              }
              .active-icon {
                  border-bottom: none;
              }
              .phone-menu {
                  display: block;
              }
              .user-menu {
                  width: fit-content;
                  right: -10px;
              }
              .user-info:hover .user-menu {
                  display: block;
              }
          }
          
      </style>

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