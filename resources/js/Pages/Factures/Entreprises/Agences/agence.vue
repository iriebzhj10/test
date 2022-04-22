<template>
   <app-layout title="Dashboard">
        <div class="col-lg-9 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">

                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">


                            <form @submit.prevent="submit">
                                <jet-validation-errors class="text-center mb-4" />
                                <jet-validation-success class="text-center mb-4" />
                                <div class="form-group">
                                    <h2 class="text-center" style="margin-bottom:2rem" > Enregistrer une Agence</h2>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p>Libellé<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input id="e-text" v-model="form.libelle" type="text" placeholder="" class="form-control">
                                            </div>
                                            <div class="col-lg-4">
                                                <p>Matricule<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Matricule</label>
                                                <input id="e-text" v-model="form.matricule" type="text" placeholder="" class="form-control">
                                            </div>
                                             <div class="col-lg-4">
                                                <p>Description<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Description</label>
                                                <input id="e-text" v-model="form.description" type="text" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Ville<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Ville</label>
                                                <input v-model="form.ville" id="e-text" type="text" placeholder="libelle" class="form-control" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Adresse<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Adresse</label>
                                                <input id="e-text" v-model="form.adresse" type="text" placeholder="" class="form-control">
                                            </div>
                                             <!-- <div class="col-lg-4">
                                                <p>Description<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Description</label>
                                                <input id="e-text" v-model="form.description" type="text" placeholder="" class="form-control">
                                            </div> -->
                                        </div>

                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Email<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Email</label>
                                                <input v-model="form.email" id="e-text" type="text" placeholder="" class="form-control" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>contact<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">contact</label>
                                                <input id="e-text" v-model="form.contact" type="text" placeholder="" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p>Ville<span class="text-danger">*</span></p>
                                            <label for="e-text" class="sr-only">ville</label>
                                            <input v-model="form.ville" id="nom" type="text" placeholder="" class="form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <p>Adresse<span class="text-danger">*</span></p>
                                            <label for="e-text" class="sr-only">adresse</label>
                                            <input v-model="form.adresse" id="prenoms" type="text" placeholder="" class="form-control" >
                                        </div>
                                    </div>

                                    <!-- <p>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Durée de l'emprunt<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Duree</label>
                                                <input v-model="form.Duree" id="e-text" type="text" placeholder="" class="form-control" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Taux d'emprunt<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Taux</label>
                                                <input id="e-text" v-model="form.Taux" type="text" placeholder="" class="form-control">
                                            </div>
                                        </div>
                                    </p> -->

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
    components:{
    Link,
    AppLayout,
    JetButton,
    JetValidationErrors,
    JetValidationSuccess
    // Offre

    },

    props:{

    },
    data() {
            return {
                form:{
                    libelle: '',
                    matricule: '',
                    description: '',
                    email: '',
                    contact: '',
                    adresse: '',
                    ville:'',
                }
            }
        },
    methods: {
        submit() {

             let data = new FormData();
                 data.append('libelle',this.form.libelle);
                 data.append('matricule',this.form.matricule);
                 data.append('description',this.form.description);
                 data.append('email',this.form.email);
                 data.append('contact',this.form.contact);
                 data.append('adresse',this.form.adresse);
                 data.append('ville',this.form.ville);
                 console.log(data);

            this.$inertia.post(this.route('agence.store'),data);``
           // form.reset();
        },

        // togglePassword:function(){
        //     this.password.type="text";
        // }

    },


}
</script>
