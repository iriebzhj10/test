<template>
    <header>
        <div id="navbar-top-main" class="navbar-top navbar-dark bg-indigo border-bottom">
            <div class="container px-0">
                <div class="navbar-nav align-items-center">
                    <div class="d-lg-inline-block">
                        <span class="navbar-text mr-3">
                            <img src="../../../public/assets/img/logo2.png" alt="Ediqia" class="img-fluid" width="100">
                        </span>
                    </div>
                    <div class="ml-auto">
                        <ul class="nav">
                            <li class="nav-link" v-if="$page.props.user">
                                   <form @submit.prevent="logout">
                                <jet-button  as="button"  class="btn btn-animated btn-animated-x btn-sm btn-lavande text-indigo rounded-pill d-lg-inline-flex" title="">
                                    <span class="btn-inner--text btn-inner--visible">
                                             Deconnexion
                                            <!-- <jet-button as="button"  class="text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>Déconnexion</jet-button> -->
                                        
                                    </span>
                                    <span class="btn-inner--hidden">
                                        <i class="fas fa-sign-out text-jaune-ambre"></i>
                                    </span>
                                </jet-button>
                                </form>
                                
                            </li>


                             <li class="nav-link" v-else>
                                <Link :href="route('login')" class="btn btn-animated btn-animated-x btn-sm btn-lavande text-indigo rounded-pill d-lg-inline-flex" title="">
                                    <span class="btn-inner--text btn-inner--visible">
                                       Connexion
                                    </span>
                                    <span class="btn-inner--hidden">
                                        <i class="fas fa-user text-jaune-ambre"></i>
                                    </span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <nav class="pt-2 pb-2 navbar-main navbar-expand-lg navbar-transparent navbar-dark bg-jaune-ambre" id="navbar-main">
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
</template>



<script>
//  import JetSideBar from '@/Jetstream/SideBar.vue'
  import { Head, Link } from '@inertiajs/inertia-vue3';
      import JetButton from '@/Jetstream/Button.vue'


export default {
    props:{
        title: String,
    },

    components:{
    Link,
    Head,
JetButton,
    },

    methods:{
         logout() {
                this.$inertia.post(route('logout'));
            },
    }
}
</script>
