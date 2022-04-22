<template>
    <app-layout>

        <div class="col-lg-10 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                        <!-- liste des agences -->
                             <h3>
                                Liste des agences <button as="button" type="button" class="btn btn-primary float-right mb-3 btn-nueva" data-toggle="modal" data-target="#myModal"><b>+</b> Ajouter</button><br />
                            </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered grocery-crud-table table-hover mt-3">
                                    <thead>
                                        <tr>
                                            <th>N0 </th>
                                            <th>Libelle</th>
                                            <th>Localisation</th>
                                            <th>Contact</th>
                                            <th>E-mail</th>
                                            <th class="text-center" colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(agence,i) in agences" :key="agence.id" >
                                            <td>{{ ++i }}  </td>
                                             <td>{{ agence.libelle }}</td>
                                             <td>{{ agence.localisation }}</td>
                                             <td>{{ agence.contact }}</td>
                                             <td>{{ agence.email }}</td>
                                             <!-- <td class="text-center"><Link class="btn btn-default btn-outline-dark mr-3" :href="'/parametre/edit/'+datas.id"><i class="icofont-edit bg-succes"> </i> </Link></td> -->
                                             <!-- <td class="text-center"> <button @click="destroy(datas.id)" class="btn btn-default btn-outline-dark btn-danger"><i class="icofont-ui-delete bg-danger"></i> </button></td> -->
                                            <!--<td class="text-center"> <Link class="btn btn-default btn-outline-dark btn-danger" :href="'/type-parametre/destroy/'+datas.id "> <i class="icofont-ui-delete bg-danger"></i></Link> </td>-->
                                            <td>
                                                <a href="javascript:void(0);" data-toggle="modal" :data-target="'#edit'+agence.id" data-placement="top" title="Modifier">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather edit-icon-color"
                                                    >
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                    </svg>
                                                </a>
                                            </td>

                                            <td>
                                                <a @click="destroy(agence.id)" href="javascript:void(0);" role="button" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather trash-icon-color feather-trash-2"
                                                    >
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                             <!-- Fin liste des agences -->

                             <!-- Modal creation d'agence -->
                            <div class="modal animate__animated animate__fadeInTopRight" id="myModal">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                                            <h3 class="text-lavande"><center>Enregistrer une agence</center></h3>
                                            <button type="button" class="close text-lavande" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form @submit.prevent="submit">
                                                <!-- <jet-validation-errors class="text-center mb-4" />
                                                <jet-validation-success class="text-center mb-4" /> -->
                                                <div class="form-group">
                                                    <h2 class="text-center" style="margin-bottom:2rem" > Enregistrer une Agence</h2>
                                                    <div style="margin-bottom:1rem">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <p>Libellé<span class="text-danger">*</span></p>
                                                                <label for="e-text" class="sr-only">Libelle</label>
                                                                <input id="e-text" v-model="form.libelle" type="text" placeholder="" class="form-control">
                                                                <div class="text-danger" v-if="errors.libelle">{{ errors.libelle }}</div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <p>Localisation<span class="text-danger">*</span></p>
                                                                <label for="e-text" class="sr-only">localisation</label>
                                                                <!-- <input id="e-text" v-model="form.localisation" type="text" placeholder="" class="form-control"> -->
                                                                <input type="search" id="address" class="form-control" placeholder="Entrer votre localisation?" v-model="form.localisation">
                                                                <div class="text-danger" v-if="errors.localisation">{{ errors.localisation }}</div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div style="margin-bottom:1rem">

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <p>Contact<span class="text-danger">*</span></p>
                                                                <label for="e-text" class="sr-only">contact</label>
                                                                <input id="e-text" v-model="form.contact" type="text" placeholder="" class="form-control">
                                                                <div class="text-danger" v-if="errors.contact">{{ errors.contact }}</div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <p>E-mail</p>
                                                                <label for="e-text" class="sr-only">email</label>
                                                                <input id="e-text" v-model="form.email" type="text" placeholder="" class="form-control">

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row" style="margin-top:2rem">
                                                        <div class="col-lg-12">
                                                            <p>Description</p>

                                                            <textarea
                                                                name=""
                                                                id="description"
                                                                cols="50"
                                                                rows="5"
                                                                placeholder="Description de l'agence"
                                                                class="w-100"
                                                                style="border: 1px solid #bfc9d4;"
                                                                v-model="form.description"
                                                            >
                                                            </textarea>
                                                        </div>

                                                    </div>
<!--
                                                    <div class="text-center">
                                                        <input type="submit" name="email" class="mt-4 btn btn-primary">
                                                    </div> -->
                                                </div>
                                            </form>
                                        </div>

                                        <!-- End Modal body -->
                                        <!-- Modal footer -->²à+²
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary btn-nueva" @click="submit()">Enregistrer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <!-- Fin Modal creation d'agence -->


                             <!-- Modal edition d'agence -->

                            <div v-for="agence in agences_edit" :key="agence.id">

                                <div class="modal animate__animated animate__fadeInTopRight" :id="'edit'+agence.id">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                                            <h3 class="text-lavande"><center>Modifier une agence</center></h3>
                                            <button type="button" class="close text-lavande" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form @submit.prevent="update(agence)">
                                                <!-- <jet-validation-errors class="text-center mb-4" />
                                                <jet-validation-success class="text-center mb-4" /> -->
                                                <div class="form-group">
                                                    <h2 class="text-center" style="margin-bottom:2rem" >Modifier une Agence</h2>
                                                    <div style="margin-bottom:1rem">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <p>Libellé<span class="text-danger">*</span></p>
                                                                <label for="e-text" class="sr-only">Libelle</label>
                                                                <input id="e-text" v-model="agence.libelle" type="text" placeholder="" class="form-control">
                                                                <div class="text-danger" v-if="errors.libelle">{{ errors.libelle }}</div>

                                                            </div>
                                                            <div class="col-lg-6">
                                                                <p>Localisation<span class="text-danger">*</span></p>
                                                                <label for="e-text" class="sr-only">localisation</label>
                                                                <!-- <input id="e-text" v-model="agence.localisation" type="text" placeholder="" class="form-control"> -->
                                                                <input type="search" id="address1" class="form-control" placeholder="Entrer votre localisation?" v-model="form.localisation"/>
                                                                <div class="text-danger" v-if="errors.localisation">{{ errors.localisation }}</div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div style="margin-bottom:1rem">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <p>Contact<span class="text-danger">*</span></p>
                                                                <label for="e-text" class="sr-only">contact</label>
                                                                <input id="e-text" v-model="agence.contact" type="text" placeholder="" class="form-control">
                                                                <div class="text-danger" v-if="errors.contact">{{ errors.contact }}</div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <p>E-mail</p>
                                                                <label for="e-text" class="sr-only">email</label>
                                                                <input id="e-text" v-model="agence.email" type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row" style="margin-top:2rem">
                                                        <div class="col-lg-12">
                                                            <p>Description</p>

                                                            <textarea
                                                                name=""
                                                                id="description"
                                                                cols="50"
                                                                rows="5"
                                                                placeholder="Description de l'agence"
                                                                class="w-100"
                                                                style="border: 1px solid #bfc9d4;"
                                                                v-model="agence.description"
                                                            >
                                                            </textarea>

                                                        </div>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- End Modal body -->
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary btn-nueva" @click="update(agence)">Enregistrer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>

                             <!-- End  Modal edition d'agence -->

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

    props:["agences" , "agences_edit", "errors" ],
    data() {
            return {
                form:{
                    libelle: '',
                    localisation:'',
                    description: '',
                    email: '',
                    contact: '',
                }
            }
        },

        mounted()
        {
            (function() {
            var placesAutocomplete = places({
            container: document.querySelector('#address')
            });
            var $address = document.querySelector('#address-value')
            placesAutocomplete.on('change', function(e) {
            $address.textContent = e.suggestion.value
                console.log(e.suggestion)
            });
            placesAutocomplete.on('clear', function() {
            $address.textContent = 'none';
            });
            })();


            (function() {
            var placesAutocomplete = places({
                container: document.querySelector('#address1')
            });

            var $address = document.querySelector('#address-value')
            placesAutocomplete.on('change', function(e) {
                $address.textContent = e.suggestion.value
                console.log(e.suggestion)
            });

            placesAutocomplete.on('clear', function() {
                $address.textContent = 'none';
            });

            })();
        },



    methods: {
        submit() {

             let data = new FormData();
                 data.append('libelle',this.form.libelle);
                 data.append('description',this.form.description);
                 data.append('email',this.form.email);
                 data.append('contact',this.form.contact);
                 data.append('localisation',this.form.localisation);
                 console.log(this.form.localisation);


            this.form.post(this.route("agence.store"), {
                    onSuccess: () => {
                        this.form.reset();
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Article ajouté avec success",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    },
                });
        },
        edit(id) {
                this.form.get("/agence/edit" + id);
        },

        update(agences) {
                let data = new FormData();
                data.append('libelle',agences.libelle);
                 data.append('description',agences.description);
                 data.append('email',agences.email);
                 data.append('adresse',agences.adresse);
                 data.append('localisation',agences.localisation);
                 console.log(data);

                this.$inertia.patch("/agence/update/" + agences.id, agences);
        },

         destroy(id) {
            Swal.fire({
                title: "Es-tu sûr?",
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, supprimez-le !",
                cancelButtonText: "Annuler",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete("/agence/destroy/" + id);
                    Swal.fire("Votre fichier a été supprimé.", "Succès");
                }
            });
        },

        // togglePassword:function(){
        //     this.password.type="text";
        // }

    },


}
</script>


