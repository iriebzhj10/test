<template>
    <app-base-layout>
        <jet-accueil-pack>
        </jet-accueil-pack>
    </app-base-layout>
</template>



<script>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import AppBaseLayout from '@/Layouts/AppBaseLayout.vue'
    import JetAccueilPack from '@/Jetstream/AccueilPack.vue'



export default {
    props:{
        title: String,
    },

    components:{
    Link,
    Head,
    AppBaseLayout,
    JetAccueilPack,
    }
}
</script>


<style>
    @import '../../../public/assets/front/libs/swiper/dist/css/swiper.min.css';
    @import '../../../public/assets/front/css/purpose.css';
    @import '../../../public/assets/front/css/ac-customize.css';
</style>
