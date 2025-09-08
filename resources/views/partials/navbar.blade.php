 <!-- Header -->
 <style>
        .logo-img {
            width: 90px;
            height: auto;
            background: transparent;
        }
</style>      
 <header class="header">
            <div class="container">
                <div class="header-content">
                    <a href="{{ route('candidats.inscription') }}" class="logo">
                         <img src="{{ asset('images/fmpo.png') }}" alt="Logo FMPO" class="logo-img">
          
                    </a>
                    <nav class="nav">
                        <a href="{{ route('candidats.inscription') }}" class="nav-link {{ $active == 'home' ? 'active' : ''  }}">Accueil</a>
                        <a href="{{ route('confirme_preregistration') }}" class="nav-link {{ $active == 'preinscription' ? 'active' : '' }}">Pré-inscription</a>
                    </nav>
                </div>
            </div>
        </header>