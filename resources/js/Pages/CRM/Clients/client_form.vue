<template>
   <app-layout title="Dashboard">
        <div class="col-lg-9 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">

                    <div class="row">

                        <div class="col-lg-12 col-12 mx-auto">
                            <jet-validation-errors class="text-center mb-4" />
                            <jet-validation-success class="text-center mb-4" />
                            <form @submit.prevent="submit">
                                <div class="form-group">
                                   
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Nom<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Nom</label>
                                                <input v-model="form.nom" id="nom" type="text" placeholder="" class="form-control">
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Prénom</p>
                                                <label for="e-text" class="sr-only">Prénom</label>
                                                <input v-model="form.prenom" id="prenoms" type="text" placeholder="" class="form-control" >
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Email<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Email</label>
                                                <input id="email" v-model="form.email" type="email" placeholder="email@mail.com" class="form-control" >
                                            </div>
                                             <div class="col-lg-6">
                                                <p>Status du client<span class="text-danger">*</span></p>
                                                <select v-model="form.type_client"  id="type_client" class="custom-select custom-select-lg" style="padding-top: 0.75rem;
                                                    padding-right: 1.25rem;
                                                    padding-bottom: 0.3rem;
                                                    padding-left: 1.25rem;">
                                                    <option selected disabled>Selectionner</option>
                                                     <option value="1">Particulier</option>
                                                    <option value="2">Entreprise</option>
                                                </select>
                                            </div>
                                        </div>
                                 
                                
                                    


                                         <div class="row">
                                            <div class="col-lg-6">
                                                <p>Pays<span class="text-danger">*</span></p>
                                                <select v-model="form.pays_id"  id="pays_id" class="custom-select custom-select-lg" style="padding-top: 0.75rem;
                                                    padding-right: 1.25rem;
                                                    padding-bottom: 0.3rem;
                                                    padding-left: 1.25rem;">
                                                    <option selected disabled>Selectionner</option>
                                                    <option value="1">Sénégal</option>
                                                    <option value="2">Côte d'Ivoire</option>
                                                </select>
                                    
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Ville</p>
                                                <label for="e-text" class="sr-only">Ville</label>
                                                <input v-model="form.ville" id="ville" type="text" class="form-control" placeholder="Ville">
                                            </div>
                                        </div>
                                  
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Numéro mobile<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Numéro mobile</label>
                                                <input v-model="form.contact" id="contact" type="text" placeholder="" class="form-control">
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Numéro Fixe</p>
                                                <label for="e-text" class="sr-only">Numéro Fixe</label>
                                                <input id="numero_fixe" v-model="form.numero_fixe" type="text" placeholder="" class="form-control">
                                            </div>
                                        </div>
                
                                    <div class="text-center">
                                    <jet-button :class="{ 'opacity-25, text-center': form.processing } " :disabled="form.processing">
                                        Valider
                                    </jet-button>                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>


<!-- liste des clients de l'utilisateur connecté -->
            
        <!-- <div class="table-responsive">
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nom</th>
                        <th>Prenoms</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Fixe</th>
                        <th>Pays</th>
                        <th>Ville</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <tr v-for="(client,i) in clients" :key="client.id">
                        <td class="text-center">{{++i}}</td>
                        <td>{{ client.nom }}</td>
                        <td>{{ client.prenoms }}</td>
                        <td>{{ client.email }}</td>
                        <td>{{ client.contact }}</td>
                        <td>{{ client.numero_fixe }}</td>
                        <td>{{ client.pays }}</td>
                        <td>{{ client.ville }}</td>
                        <td v-if="client.type_client==='1'">Particulier</td>
                        <td v-else-if="article.type==='2'">Entreprise</td>
                    
                    
                        <td class="text-center">
                            <ul class="table-controls">
                                <li><a href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
                                <li><a @click="destroy(client.id)" href="javascript:void(0);"  role="button" data-toggle="tooltip" data-placement="top" title="delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a></li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> -->

<!-- end___ liste des clients de l'utilisateur connecté -->
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
    props:['clients'],

    components:{
        JetValidationErrors,
        JetValidationSuccess,
          JetButton,
          AppLayout,
        Head,
        Link
    },

    data() {
            return {
                form:{
                    nom: '',
                    prenom: '',
                    email: '',
                    pays_id: '',
                    type_client:'',
                    ville: '',
                    contact: '',
                    numero_fixe: '',
                    status: '',

                },
                i:0,
            }
        },
    methods: {
        submit() {
            this.$inertia.post(this.route('client.store'),this.form);
        },

        destroy(id){
            this.$inertia.delete('/client/destroy'+id);
        },

    }

}
</script>
