<template>
    <head title="Gestion des clients" />
    <app-layout title="Client">
        <div class="col-lg-12 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                            <!-- liste des clients de l'utilisateur connecté -->
                            <h3>
                                Liste des clients <button as="button" type="button" class="btn btn-primary float-right mb-3 btn-nueva" data-toggle="modal" data-target="#myModal"><b>+</b> Ajouter</button><br />
                            </h3>
                            <div class="table-responsive">
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
                                            <th class="text-center" colspan="2">Action</th>
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
                                            <td v-else-if="client.type_client==='2'">Entreprise</td>
                                            <td>
                                                <a href="javascript:void(0);" data-toggle="modal" :data-target="'#edit'+client.id" data-placement="top" title="Edit">
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
                                                <a @click="destroy(client.id)" href="javascript:void(0);" role="button" data-toggle="tooltip" data-placement="top" title="delete">
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

                            <!-- END liste des clients de l'utilisateur connecté -->

                            <!-- Modal creation de client -->

                            <div class="modal animate__animated animate__fadeInTopRight" id="myModal">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                                            <h3 class="text-lavande"><center>Créer un client</center></h3>
                                            <button type="button" class="close text-lavande" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form @submit.prevent="submit">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <!-- <jet-validation-success class="text-center mb-4" /> -->
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <p>Nom<span class="text-danger">*</span></p>
                                                            <label for="e-text" class="sr-only">Nom</label>
                                                            <input v-model="form.nom" id="nom" type="text" placeholder="" class="form-control" />
                                                            <div class="text-danger" v-if="errors.nom">{{ errors.nom }}</div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <p>Prénom</p>
                                                            <label for="e-text" class="sr-only">Prénom</label>
                                                            <input v-model="form.prenom" id="prenoms" type="text" placeholder="" class="form-control" />
                                                            <div class="text-danger" v-if="errors.prenom">{{ errors.prenom }}</div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6 mt-3">
                                                            <p>Email<span class="text-danger">*</span></p>
                                                            <label for="e-text" class="sr-only">Email</label>
                                                            <input id="email" v-model="form.email" type="email" placeholder="email@mail.com" class="form-control" />
                                                            <div class="text-danger" v-if="errors.email">{{ errors.email }}</div>
                                                        </div>
                                                        <div class="col-lg-6 mt-3">
                                                            <p>Status du client<span class="text-danger">*</span></p>
                                                            <select
                                                                v-model="form.type_client"
                                                                id="type_client"
                                                                class="custom-select custom-select-lg"
                                                                style="padding-top: 0.75rem; padding-right: 1.25rem; padding-bottom: 0.3rem; padding-left: 1.25rem;"
                                                            >
                                                                <option selected disabled>Selectionner</option>
                                                                <option value="1">Particulier</option>
                                                                <option value="2">Entreprise</option>
                                                            </select>
                                                            <div class="text-danger" v-if="errors.type_client">{{ errors.type_client }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mt-3">
                                                            <p>Pays<span class="text-danger">*</span></p>
                                                            <select
                                                                v-model="form.pays"
                                                                id="pays_id"
                                                                class="custom-select custom-select-lg"
                                                                style="padding-top: 0.75rem; padding-right: 1.25rem; padding-bottom: 0.3rem; padding-left: 1.25rem;"
                                                            >
                                                                <option selected disabled>Selectionner</option>
                                                                <option value="1">Sénégal</option>
                                                                <option value="2">Côte d'Ivoire</option>
                                                            </select>
                                                            <div class="text-danger" v-if="errors.pays">{{ errors.pays }}</div>
                                                        </div>
                                                        <div class="col-lg-6 mt-3">
                                                            <p>Ville</p>
                                                            <label for="e-text" class="sr-only">Ville</label>
                                                            <input type="search" id="address" class="form-control" placeholder="Entrer votre localisation?" v-model="form.ville"/>
                                                            <!-- <input v-model="form.ville" id="ville" type="text" class="form-control" placeholder="Ville" /> -->
                                                            <div class="text-danger" v-if="errors.ville">{{ errors.ville }}</div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6 mt-3">
                                                            <p>Numéro mobile<span class="text-danger">*</span></p>
                                                            <label for="e-text" class="sr-only">Numéro mobile</label>
                                                            <input v-model="form.contact" id="contact" type="text" placeholder="" class="form-control" />
                                                            <div class="text-danger" v-if="errors.contact">{{ errors.contact }}</div>
                                                        </div>
                                                        <div class="col-lg-6 mt-3">
                                                            <p>Numéro Fixe</p>
                                                            <label for="e-text" class="sr-only">Numéro Fixe</label>
                                                            <input id="numero_fixe" v-model="form.numero_fixe" type="text" placeholder="" class="form-control" />
                                                            <div class="text-danger" v-if="errors.numero_fixe">{{ errors.numero_fixe }}</div>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="text-center"><br>
                                                    <jet-button :class="{ 'opacity-25, text-center': form.processing } " :disabled="form.processing" class="w-25 m-auto">
                                                        Valider
                                                    </jet-button>
                                                     </div> -->
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary btn-nueva" @click="submit()">Enregistrer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--END Modal creation de client -->

                            <!-- Modal edition de client -->

                            <div v-for="client in clients_edit" :key="client.id">
                                <div class="modal animate__animated animate__zoomInDown" :id="'edit'+client.id">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header modal-header-border-bottom bg-indigo">
                                                <h3 class="text-lavande"><center>Modifier un client</center></h3>
                                                <button type="button" class="close text-lavande" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form @submit.prevent="update(client)">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <!-- <jet-validation-success class="text-center -->
                                                                <!-- mb-4" /> -->
                                                                <!-- <jet-validation-errors class="text-center mb-4" /> -->
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <p>Nom<span class="text-danger">*</span></p>
                                                                <label for="e-text" class="sr-only">Nom</label>
                                                                <input v-model="client.nom" id="nom" type="text" placeholder="" class="form-control" />
                                                                <div class="text-danger" v-if="errors.nom">{{ errors.nom }}</div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <p>Prénom</p>
                                                                <label for="e-text" class="sr-only">Prénom</label>
                                                                <input v-model="client.prenoms" id="prenoms" type="text" placeholder="" class="form-control" />
                                                                <div class="text-danger" v-if="errors.prenom">{{ errors.prenom }}</div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6 mt-3">
                                                                <p>Email<span class="text-danger">*</span></p>
                                                                <label for="e-text" class="sr-only">Email</label>
                                                                <input id="email" v-model="client.email" type="email" placeholder="email@mail.com" class="form-control" />
                                                                <div class="text-danger" v-if="errors.email">{{ errors.email }}</div>
                                                            </div>
                                                            <div class="col-lg-6 mt-3">
                                                                <p>Status du client<span class="text-danger">*</span></p>
                                                                <select
                                                                    v-model="client.type_client"
                                                                    id="type_client"
                                                                    class="custom-select custom-select-lg"
                                                                    style="padding-top: 0.75rem; padding-right: 1.25rem; padding-bottom: 0.3rem; padding-left: 1.25rem;"
                                                                >
                                                                    <option selected disabled>Selectionner</option>
                                                                    <option value="1">Particulier</option>
                                                                    <option value="2">Entreprise</option>
                                                                </select>
                                                                <div class="text-danger" v-if="errors.type_client">{{ errors.type_client }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 mt-3">
                                                                <p>Pays<span class="text-danger">*</span></p>
                                                                <select
                                                                    v-model="client.pays"
                                                                    id="pays_id"
                                                                    class="custom-select custom-select-lg"
                                                                    style="padding-top: 0.75rem; padding-right: 1.25rem; padding-bottom: 0.3rem; padding-left: 1.25rem;"
                                                                >
                                                                    <option selected disabled>Selectionner</option>
                                                                    <option value="1">Sénégal</option>
                                                                    <option value="2">Côte d'Ivoire</option>
                                                                </select>
                                                                <div class="text-danger" v-if="errors.pays">{{ errors.pays }}</div>
                                                            </div>
                                                            <div class="col-lg-6 mt-3">
                                                                <p>Ville</p>
                                                                <label for="e-text" class="sr-only">Ville</label>
                                                                <input type="search" id="address1" class="form-control" placeholder="Where are we going?" v-model="client.ville"/>
                                                                <!-- <input v-model="client.ville" id="ville" type="text" class="form-control" placeholder="Ville" /> -->
                                                                <div class="text-danger" v-if="errors.ville">{{ errors.ville }}</div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6 mt-3">
                                                                <p>Numéro mobile way<span class="text-danger">*</span></p>
                                                                <label for="e-text" class="sr-only">Numéro mobile way</label>
                                                                <input v-model="client.contact" id="contact" type="text" placeholder="" class="form-control" />
                                                                <div class="text-danger" v-if="errors.contact">{{ errors.contact }}</div>
                                                            </div>
                                                            <div class="col-lg-6 mt-3">
                                                                <p>Numéro Fixe</p>
                                                                <label for="e-text" class="sr-only">Numéro Fixe</label>
                                                                <input id="numero_fixe" v-model="client.numero_fixe" type="text" placeholder="" class="form-control" />
                                                                <div class="text-danger" v-if="errors.numero_fixe">{{ errors.numero_fixe }}</div>
                                                            </div>
                                                        </div>

                                                        <!-- <div class="text-center"><br>
                                                    <jet-button :class="{ 'opacity-25, text-center': form.processing } " :disabled="form.processing" class="w-25 m-auto">
                                                        Valider
                                                    </jet-button>
                                                     </div> -->
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary btn-nueva" @click="update(client)">Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <!--END Modal edition de client -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { Head, Link } from "@inertiajs/inertia-vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import JetButton from "@/Jetstream/Button.vue";
    import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
    import JetValidationSuccess from "@/Jetstream/ValidationSuccess.vue";

    //   import Offre from '@/Pages/Factures/Offre.vue'

    export default {
        props: ["clients", "clients_edit", "errors"],

        components: {
            JetValidationErrors,
            JetValidationSuccess,
            JetButton,
            AppLayout,
            Head,
            Link,
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

        data() {
            return {
                form: this.$inertia.form({
                    nom: "",
                    prenom: "",
                    email: "",
                    pays: "",
                    type_client: "",
                    ville: "",
                    contact: "",
                    numero_fixe: "",
                    status: "",
                }),
                i: 0,
            };
        },
        methods: {
            submit() {
                this.form.post(this.route("client.store"), {
                    onSuccess: () => {
                        this.form.reset();
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Client modifié avec success",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    },
                });
            },

            update(clients) {
                this.$inertia.patch("/client/update/" + clients.id, clients);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Client modifié avec success",
                    showConfirmButton: false,
                    timer: 1500,
                });
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
                        this.form.delete("/client/destroy" + id);
                        Swal.fire("Votre fichier a été supprimé.", "Succès");
                    }
                });
            },

            edit(id) {
                this.form.get("/client/edit" + id);
            },
        },
    };
</script>
