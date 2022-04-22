<header>
    <div id="navbar-top-main" class="navbar-top navbar-dark bg-indigo border-bottom">
        <div class="container px-0">
            <div class="navbar-nav align-items-center">
                <div class="d-lg-inline-block">
                    <span class="navbar-text mr-3">
                        <img src="{{ asset('assets/img/logo2.png') }}" alt="Ediqia" class="img-fluid" width="100">
                    </span>
                </div>
                <div class="ml-auto">
                    <ul class="nav">
                        <li class="nav-link">
                            <a href="{{ route('register') }}" class="btn btn-animated btn-animated-x btn-sm btn-lavande text-indigo rounded-pill d-lg-inline-flex" title="">
                                <span class="btn-inner--text btn-inner--visible">Inscription</span>
                                <span class="btn-inner--hidden">
                                    <i class="fas fa-user text-jaune-ambre"></i>
                                </span>
                            </a>
                        </li>
                        {{--<li class="nav-link">
                            <a href="{{ route('logout') }}" class="btn btn-animated btn-animated-x btn-sm btn-lavande text-indigo rounded-pill d-none d-lg-inline-flex" title="">
                        <li class="nav-link">
                            <a href="#" class="btn btn-animated btn-animated-x btn-sm btn-lavande text-indigo rounded-pill d-none d-lg-inline-flex" title="">
                                <span class="btn-inner--text btn-inner--visible">Déconnexion</span>
                                <span class="btn-inner--hidden">
                                    <i class="fas fa-sign-out-alt text-jaune-ambre"></i>
                                </span>
                            </a>
                        </li>--}}
                        {{--<li class="nav-item">
                            <a href="#" class="nav-link" data-action="omnisearch-open" data-target="#omnisearch"><i class="fas fa-search nav-recherche-icon"></i></a>
                        </li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<nav class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-dark bg-jaune-ambre" id="navbar-main">
    <div class="container px-lg-0">
        <!-- Navbar collapse trigger -->
        <button class="navbar-toggler pr-0" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar nav -->
        <div class="collapse navbar-collapse" id="navbar-main-collapse">
            <ul class="navbar-nav align-items-lg-center m-auto">
                <!-- Home - Overview  -->
                <li class="nav-item">
                    <a class="nav-link active text-dark" style="font-size: 17px;" href="#">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" style="font-size: 17px;" href="#apropos">A-propos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" style="font-size: 17px;" href="#fonctionnalite">Fonctionnalités</a>
                </li>
                <!-- Sections menu -->
                <li class="nav-item dropdown dropdown-animate" data-toggle="hover">
                    <a class="nav-link text-dark" style="font-size: 17px;" href="#">Comment ça marche ?</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="omnisearch" class="omnisearch">
    <div class="container">
        <!-- Search form -->
        <form class="omnisearch-form">
            <div class="form-group">
                <div class="input-group input-group-merge input-group-flush">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Type and hit enter ..." />
                </div>
            </div>
        </form>
    </div>
</div>
