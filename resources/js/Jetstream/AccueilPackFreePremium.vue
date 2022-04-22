<template>
    <section class="slice slice-lg bg-lavande" data-offset-top="#header-main">
        <div class="container pt-5 pt-xl-6 pb-xl-5">
        <div class="row row-grid align-items-center">
            <div class="col-lg-5">
            <h5 class="h1">Simple d'accès et riche en fonctionnalités.</h5>
            <p class="lead my-4">Lorsque vous achetez, vous obtenez un pack de gestion haute qualité pour commencer à gérer votre entreprise facilement.</p>
            <small class="text-indigo">Essayez gratuitement pendant 14 jours, aucune carte de crédit requise.</small>
            <div class="mt-5">
                <button type="button" class="btn btn-soft-indigo mr-lg-4">
                    Commencer
                </button>
            </div>
            </div>
            <div class="col-xl-6 col-lg-7 offset-xl-1">
            <div class="row">
                <div class="col-sm-6">
                <div class="card card-pricing border-md border-jaune text-center scale-110 popular bg-indigo">
                    <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-jaune-ambre text-white">Premium</span>
                    <div class="card-header py-5 border-0">
                    <div class="h1 text-lavande text-center mb-0" data-pricing-value="396">
                        <span class="price">25.000<span class="h5 ml-1 mr-1 text-lavande">XOF</span></span><span class="h6 m-0 text-jaune-ambre">/ mois</span></div>
                    </div>
                    <div class="card-body delimiter-top text-lavande">
                    <ul class="list-unstyled mb-4">
                        <li>- Gestion d'utilisateurs -</li>
                        <li>- Création de relances -</li>
                        <li>- Crétaion de factures -</li>
                        <li>- Création de Devis -</li>
                    </ul>
                    </div>
                </div>
                </div>
                <div class="col-sm-6">
                <div class="card card-pricing text-center bg-indigo">
                    <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-jaune-ambre text-lavande">Gratuit</span>
                    <div class="card-header py-5 border-0">
                    <div class="h1 text-lavande text-center mb-0" data-pricing-value="196"><span class="price ">14</span><span class="h6 ml-2 text-jaune-ambre">Jours</span></div>
                    </div>
                    <div class="card-body delimiter-top text-lavande">
                    <ul class="list-unstyled mb-4">
                        <li>- Gestion d'utilisateurs -</li>
                        <li>- Gestion de relances -</li>
                        <li>- Gestion de factures -</li>
                        <li>- Création de Devis -</li>
                    </ul>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
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
