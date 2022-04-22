<template>
   <app-layout title="Dashboard">
        <div class="col-lg-9 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">

                    <div class="row">

                        <div class="col-lg-12 col-12 mx-auto">
                            <form @submit.prevent="submit">
                                <div class="form-group">
                                    <h2 class="text-center" style="margin-bottom:2rem" >Enregistrer des Emprunts</h2>
                                    <div>
                                        <p>Selectionner un Créancier<span class="text-danger">*</span></p>
                                        <div class="form-row mb-4">
                                            <div class="col-12">
                                                <select v-model="form.Créancier" class="custom-select custom-select-lg">
                                                    <option selected>Bancaire</option>
                                                    <option value="1">caisse</option>
                                                </select>
                                            </div>
                                        </div>
                                         <!-- <div class="col-lg-6">
                                                <p>Libelle<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input id="e-text" v-model="form.Libelle" type="text" placeholder="" class="form-control">
                                            </div> -->
                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p>Libellé<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input v-model="form.Libelle" id="e-text" type="text" placeholder="" class="form-control" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <p>Description<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Description</label>
                                                <input id="e-text" v-model="form.Description" type="text" placeholder="" class="form-control">
                                            </div>
                                             <div class="col-lg-4">
                                                <p>Montant<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Montant</label>
                                                <input id="e-text" v-model="form.Montant" type="text" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Date d'emprunt<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">emprunt</label>
                                                <input v-model="form.emprunt" id="e-text" type="text" placeholder="" class="form-control" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Date de rembourssement<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">rembourssement</label>
                                                <input id="e-text" v-model="form.rembourssement" type="text" placeholder="" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
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
            this.$inertia.post(this.route('client.store'),this.form);
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
