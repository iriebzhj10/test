

<template>
    <Head title="welcome" />

    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <div class="container alert alert-success pt-5 pb-5" role="alert">
                            <h1 class="text-center mb-3 blink_me">Felicitations!!!</h1>
                            <h6 class="text-center"> Votre entreprise a bien été enregistrées. Merci de faire confiance à Ediqia</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </jet-authentication-card>
</template>

<script>
 import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
      import { Head, Link } from '@inertiajs/inertia-vue3'
export default {
 components:{
        Head,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        Link,
 }
}

</script>
