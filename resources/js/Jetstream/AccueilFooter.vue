<template>
    <footer id="footer-main">
        <div class="footer footer-dark bg-indigo">
            <div class="container">
                <div class="row pt-md">
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <a href="#" style="color: #efc300;">
                            <img src="../../../public/assets/img/logo2.png" class="logo" alt="logo">
                        </a>
                        <p>Plus qu'un logiciel de gestion. Ediqia est destiné à être votre meilleur ami.</p>
                    </div>
                    <div class="col-lg-2 col-6 col-sm-4 ml-lg-auto mb-5 mb-lg-0">
                        <h6 class="heading mb-3">Site</h6>
                        <ul class="list-unstyled">
                            <li><a href="#">Accueil</a></li>
                            <li><a href="#">A-propos</a></li>
                            <li><a href="#">Comment ça marche</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4 mb-5 mb-lg-0">
                        <h6 class="heading mb-3">Liens rapides</h6>
                        <ul class="list-unstyled text-small">
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Compte</a></li>
                            <li><a href="#">Carrière</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-sm-4 mb-5 mb-lg-0">
                        <h6 class="heading mb-3">Entreprise</h6>
                        <ul class="list-unstyled">
                            <li><a href="#">Conditions</a></li>
                            <li><a href="#">Politique de confidentialité</a></li>
                            <li><a href="#">Support</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row align-items-center justify-content-md-between py-4 mt-4 delimiter-top">
                    <div class="col-md-6">
                        <div class="copyright text-sm font-weight-bold text-center text-md-left">&copy; 2020-2021 <a href="#" class="font-weight-bold" target="_blank">ediqia</a>. All rights reserved.</div>
                    </div>
                    <div class="col-md-6">
                        <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fab fa-dribbble"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>



<script>
//  import JetSideBar from '@/Jetstream/SideBar.vue'
  import { Head, Link } from '@inertiajs/inertia-vue3';


export default {
    props:{
        title: String,
    },

    components:{
    Link,
    Head
    }
}
</script>
