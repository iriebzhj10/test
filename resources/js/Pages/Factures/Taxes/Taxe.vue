<template>

    <app-layout title="Taxe">
        <div class="col-lg-9 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                            <!-- liste des clients de l'utilisateur connecté -->

                            <h3>
                                Liste des taxes <button as="button" type="button" class="btn btn-primary btn-nueva float-right mb-3" data-toggle="modal" data-target="#myModal"><b>+</b> Ajouter</button><br />
                            </h3>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>

                                            <th>Libelle</th>

                                            <th>Valeur</th>

                                            <th class="text-center" colspan="2">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(taxe,i) in taxes" :key="taxe.id">
                                            <td class="text-center">{{++i}}</td>

                                            <td>{{ taxe.libelle }}</td>

                                            <td>{{ taxe.valeur }}</td>

                                            <td class="text-center">
                                                <a href="javascript:void(0);" data-toggle="modal" :data-target="'#edit'+taxe.id" data-placement="top" title="Edit">
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
                                            <td class="text-center">
                                                <a @click="destroy(taxe.id)" href="javascript:void(0);" role="button" data-toggle="tooltip" data-placement="top" title="delete">
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
                                                        class="feather trash-icon-color"
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

                            <!-- Modal creation de client -->

                            <div class="modal" id="myModal">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <!-- Modal Header -->

                                        <div class="modal-header">
                                            <h3><center>Créer une taxe</center></h3>

                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->

                                        <div class="modal-body">
                                            <!-- <jet-validation-success class="text-center mb-4" /> -->
                                            <form @submit.prevent="submit">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <p>Libelle<span class="text-danger">*</span></p>

                                                            <label for="e-text" class="sr-only">Libelle</label>

                                                            <input id="libelle" type="text" placeholder="" class="form-control" v-model="form.libelle" />

                                                            <div class="text-danger" v-if="errors.libelle">{{errors.libelle}}</div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <p>Valeur</p>

                                                            <label for="e-text" class="sr-only">Valeur</label>

                                                            <input type="number" id="valeur" placeholder="" class="form-control" v-model="form.valeur" />

                                                            <div class="text-danger" v-if="errors.valeur">{{errors.valeur}}</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="text-center">
                                                    <jet-button :class="{ 'opacity-25, text-center': form.processing } " :disabled="form.processing">
                                                        Valider
                                                    </jet-button>
                                                </div> -->

                                                <div class="modal-footer">
                                                    <jet-button :class="{ 'opacity-25, text-center': form.processing } " :disabled="form.processing">
                                                        Valider
                                                    </jet-button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Modal footer -->
                                    </div>
                                </div>
                            </div>

                            <!--END Modal creation de taxe -->

                            <!-- Modal modification de taxe -->
                            <div v-for="(taxe) in taxes_edit" :key="taxe.id">
                                <div class="modal" :id="'edit'+taxe.id">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <!-- Modal Header -->

                                            <div class="modal-header">
                                                <h3><center>Créer une taxe</center></h3>

                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->

                                            <div class="modal-body">
                                                <form @submit.prevent="update(taxe)">
                                                    <div class="form-group">
                                                        <div>
                                                            <!-- <jet-validation-success class="text-center mb-4" /> -->
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                            <p>Libelle<span class="text-danger">*</span></p>

                                                            <label for="e-text" class="sr-only">Libelle</label>

                                                            <input id="libelle" type="text" placeholder="" class="form-control" v-model="taxe.libelle" />

                                                            <div class="text-danger" v-if="errors.libelle">{{errors.libelle}}</div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <p>Valeur</p>

                                                                <label for="e-text" class="sr-only">Valeur</label>

                                                                <input type="text" id="valeur" placeholder="" class="form-control" v-model="taxe.valeur" />

                                                                <div class="text-danger" v-if="errors.valeur">{{errors.valeur}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Modal footer -->

                                            <div class="modal-footer">
                                                <div class="text-center" @click="update(taxe)">
                                                    <jet-button :class="{ 'opacity-25, text-center': form.processing } " :disabled="form.processing">
                                                        Valider
                                                    </jet-button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--END Modal modification de client -->
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

    // import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";

    // import JetValidationSuccess from "@/Jetstream/ValidationSuccess.vue";

    export default {
        components: {
            Head,

            Link,

            JetButton,

            AppLayout,

            // JetValidationErrors,

            // JetValidationSuccess,
        },

        props: ["taxes", "taxes_edit", "errors"],

        data() {
            return {
                form: this.$inertia.form({
                    libelle: "",

                    valeur: "",
                }),
                i: 0,
            };
        },

        methods: {
            submit() {
                this.form.post(this.route("taxe.store"), {
                    onSuccess: () => {
                        this.form.reset();
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Taxe ajouté avec success",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    },
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
                        this.form.delete("/taxe/destroy/" + id);
                        Swal.fire("Votre fichier a été supprimé.", "Succès");
                    }
                });
            },

            update(taxes) {
                this.$inertia.put("/taxe/update/" + taxes.id, taxes);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Taxe modifié avec success",
                    showConfirmButton: false,
                    timer: 1500,
                });
            },
        },
    };
</script>
