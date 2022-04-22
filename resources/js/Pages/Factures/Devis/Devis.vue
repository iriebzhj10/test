<template>
   <app-layout title="Dashboard">
        <div class="col-lg-9 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>




<script>
  import { Head, Link } from '@inertiajs/inertia-vue3'
  import AppLayout from '@/Layouts/AppLayout.vue'
  import JetButton from '@/Jetstream/Button.vue'

//   import Offre from '@/Pages/Factures/Offre.vue'

export default {
    props:{

    },
    data() {
            return {
                form:{
                    nom: '',
                    prenom: '',
                    email: '',
                    pays: '',
                    ville: '',
                    numero_mobile: '',
                    numero_fixe: '',
                    status: '',
                    adresse: '',

                }
            }
        },
    methods: {
        submit() {
            this.$inertia.post(this.route('Devis.store'),this.form);
            form.reset();
        },

        // togglePassword:function(){
        //     this.password.type="text";
        // }

    },

    components:{
    Link,
    AppLayout,
    JetButton,
    // Offre

    }
}
</script>
