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
                                    <h2 class="text-center" style="margin-bottom:2rem" >Enregistrement des Créanciers</h2>

                                     <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Type Créancier<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input v-model="form.type" id="e-text" type="text" placeholder="nom/entreprise" class="form-control"  >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Mail<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Mail</label>
                                                <input id="e-text" v-model="form.email" type="text" placeholder="+2550000000000" class="form-control">
                                            </div>
                                        </div>

                                    </div><br/>

                                    <div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p>Libellé<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input v-model="form.libelle" id="e-text" type="text" placeholder="nom/entreprise" class="form-control" >
                                            </div>
                                            <div class="col-lg-4">
                                                <p>Contact<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Contact</label>
                                                <input id="e-text" v-model="form.contact" type="text" placeholder="+2550000000000" class="form-control">
                                            </div>
                                             <div class="col-lg-4">
                                                <p>Adresse<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Adresse</label>
                                                <input id="e-text" v-model="form.adresse" type="text" placeholder="name@entreprise" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <!-- <p>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Montant<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Montant</label>
                                                <input v-model="form.Montant" id="e-text" type="text" placeholder="" class="form-control" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Description<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Description</label>
                                                <input id="e-text" v-model="form.Description" type="text" placeholder="" class="form-control">
                                            </div>
                                        </div>
                                    </p> -->

                                    <div class="text-center">
                                        <input type="submit" name="envoyer" class="mt-4 btn btn-primary" >
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
    props:{

    },
    data() {
            return {
                form:{
                    type: '',
                    libelle: '',
                    contact: '',
                    adresse: '',
                    email:'',
                }
            }
        },
    methods: {
        submit() {
             let data = new FormData();
                 data.append('libelle',this.form.libelle);
                 data.append('type',this.form.type);
                 data.append('email',this.form.email);
                 data.append('adresse',this.form.adresse);
                 data.append('contact',this.form.contact);
                 console.log(data);
                 this.$inertia.post(this.route('creancier.store'),data);
                // form.reset();

                //  this.$inertia.post(this.route('creancier.store'),data);
                //  console.log(form);
                //  form.reset();
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
