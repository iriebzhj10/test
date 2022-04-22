<template>
   <app-layout title="Dashboard">
        <div class="col-lg-9 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">

                    <div class="row">

                        <div class="col-lg-12 col-12 mx-auto">
                            <form @submit.prevent="submit">
                                <div class="form-group">
<jet-validation-errors class="text-center mb-4" />
                                <jet-validation-success class="text-center mb-4" />

                                <h2 class="m-auto mx-5">Ajouter un compte</h2><br><br>

                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Numero du compte<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Numéro compte</label>
                                                <input v-model="form.compte" id="e-text" type="text" name="compte" placeholder="" class="form-control" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Libelle<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input id="e-text" v-model="form.libelle" type="text" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Montant<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Montant</label>
                                                <input v-model="form.montant"  type="text" placeholder="" class="form-control" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Description<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Description</label>
                                                <input id="e-text" v-model="form.description" type="text" placeholder="" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <input type="submit" name="email" class="mt-4 btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>

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
  import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
      import JetValidationSuccess from '@/Jetstream/ValidationSuccess.vue'


//   import Offre from '@/Pages/Factures/Offre.vue'

export default {
    props: ['datas'],
    data() {
            return {
                form:{

compte: '',
                    libelle: '',
                    montant: '',
                    description: '',

                }
            }
        },
    methods: {
        submit() {
            this.$inertia.post(this.route('compte.store'),this.form);
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
    JetValidationErrors,
    JetValidationSuccess,



    // Offre

    }
}
</script>
