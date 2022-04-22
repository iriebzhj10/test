<template>
    <app-layout title="Dashboard" class="container-fluid">
        <div class="container">
            <div class="row mt-2 mp-2">
                <div class="col-lg-9 card">
                    <!-- Logo et numero de facture -->
                    <div class="row pt-4 pb-4">
                        <div class="col-6">
                            <div class="invoice-logo pl-3">
                                <div class="upload-logo">
                                    <div class="upload" @click="chooseFile">
                                        <input v-if="picture === ''" @change="processFile($event)" type="file" id="input-file" hidden data-max-file-size="2M" />
                                        <img v-if="picture === ''" src="../../../../../public/assets/img/upload-icon.svg" alt="upload icon" />
                                        <p v-if="picture === ''">
                                            Choisir votre logo
                                        </p>
                                    </div>
                                    <img
                                        src=""
                                        alt=""
                                        id="logo-img"
                                        :class="
                                            choose ? 'visible' : 'invisible'
                                        "
                                    />
                                    <button
                                        @click="deletePicture"
                                        :class="
                                            choose ? 'visible' : 'invisible'
                                        "
                                    >
                                        x
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="align-right pr-4">
                                <form>
                                    <input class="form-control" type="text" name="numFacture" id="numFacture" value="#123-45-10" disabled />
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row pt-4 pb-4">
                        <!-- l'entreprise -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="text-center text-indigo">Entreprise</h3>
                                </div>
                            </div>
                            <div class="card pl-3 ml-3 pt-4 pb-4 mr-3">
                                <div class="row pb-3">
                                    <div class="col-3 d-flex">Nom</div>
                                    <div class="col-9 text-indigo font-weight-bold">
                                        Coulibaly
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-3 d-flex">Prénom</div>
                                    <div class="col-9 text-indigo font-weight-bold">
                                        Cheick Oumar
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-3 d-flex">Email</div>
                                    <div class="col-9 text-indigo font-weight-bold">
                                        cheick.oumar.coulby@gmail.com
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-3 d-flex pr-4">Adresse</div>
                                    <div class="col-9 text-indigo font-weight-bold">
                                        Cocody
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-3 d-flex">Téléphone</div>
                                    <div class="col-9 d-flex text-indigo font-weight-bold">
                                        0586666458
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- client -->
                        <div class="col-lg-6 col-sm-12 client">
                            <div class="row">
                                <div class="col-lg-12 text-center mt-3" style="position: relative;">
                                    <button class="btn-primary btn-lg m-auto client-list">
                                        <span>Liste des clients</span> <i class="icofont-plus-circle text-lavande"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="pl-3 ml-3 pt-4 pb-4 mr-3 client-info">
                                <div class="row pb-3">
                                    <div class="col-3 d-flex">Nom</div>
                                    <form>
                                        <input class="form-control" type="text" name="numFacture" id="numFacture" value="Coulibaly" />
                                    </form>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-3 d-flex">Prénom</div>
                                    <form>
                                        <input class="form-control" type="text" name="numFacture" id="numFacture" value="Cheick Oumar" />
                                    </form>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-3 d-flex">Email</div>
                                    <form>
                                        <input class="form-control" type="text" name="numFacture" id="numFacture" value="cheick.oumar.coulby@gmail.com" />
                                    </form>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-3 d-flex pr-4">Adresse</div>
                                    <form>
                                        <input class="form-control" type="text" name="numFacture" id="numFacture" value="Cocody" />
                                    </form>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-3 d-flex">Téléphone</div>
                                    <form>
                                        <input class="form-control" type="text" name="numFacture" id="numFacture"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-12">
                            <h3 class="text-indigo">Article</h3>
                        </div>
                    </div>
                    <div class="row pb-4">
                        <table class="table table-responsive">
                            <thead class="bg-lavande text-center">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Taxe</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Remise</th>
                                <th scope="col">Dupliquer</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr id="element">
                                    <th scope="row">{{ tableLine }}</th>
                                    <td>
                                        <select class="selectpicker" data-live-search="true">
                                            <option>Fries</option>
                                            <option>Burger, Shake and a Smile</option>
                                            <option>Sugar, Spice and all things nice</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="custom-select custom-select-sm" id="domaine_id" v-model="form.domaine_id">
                                            <option>12,5</option>
                                        </select>
                                    </td>
                                    <td>
                                        <form>
                                            <input class="form-control" type="text" name="numFacture" id="numFacture"/>
                                        </form>
                                    </td>
                                    <td>
                                        <form>
                                            <input class="form-control" type="number" name="numFacture" id="numFacture"/>
                                        </form>
                                    </td>
                                    <td>
                                        <form>
                                            <input class="form-control" type="text" name="numFacture" id="numFacture"/>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <button @click="duplicate">
                                            <i class="icofont-ui-copy text-indigo h4"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="row pb-4">
                        <div class="col-12">
                            <h3 class="text-indigo text-center">Paiement</h3>
                        </div>
                    </div>
                    <div class="row m-auto">
                        <div class="col">
                            <div class="n-chk">
                                <label class="new-control new-radio new-radio-text radio-primary">
                                <input type="radio" class="new-control-input" name="custom-radio-4">
                                <span class="new-control-indicator"></span><span class="new-radio-content"><i class="icofont-visa-alt paiement text-indigo"><span style="font-size:20px;">Visa</span></i></span>
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="n-chk">
                                <label class="new-control new-radio new-radio-text radio-primary">
                                <input type="radio" class="new-control-input" name="custom-radio-4">
                                <span class="new-control-indicator"></span><span class="new-radio-content"><i class="icofont-mastercard-alt paiement text-indigo"><span style="font-size:20px;">Mastercard</span></i></span>
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="n-chk">
                                <label class="new-control new-radio new-radio-text radio-primary">
                                <input type="radio" class="new-control-input" name="custom-radio-4">
                                <span class="new-control-indicator"></span><span class="new-radio-content"><i class="icofont-bank-transfer-alt text-indigo paiement"><span style="font-size:20px;">Virement bancaire</span></i></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 ml-1card"></div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { Head, Link } from "@inertiajs/inertia-vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import JetButton from "@/Jetstream/Button.vue";
    import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
    //   import Offre from '@/Pages/Factures/Offre.vue'

    export default {
        props: ["users", "entreprise", "clients", "articles", "taxes", "errors"],

        data() {
            return {
                picture: "",
                choose: false,
                tableLine: 1,
                form: [
                    {
                        libelle: "",
                        nom: "",
                        today_date: "",
                        date_echeace: "",
                        prix_unitaire: "",
                        article_id: "",
                        compte_id: "",
                        bank_name: "",
                        payment_method_code: "",
                        taxe: "",
                        pays: "",
                        description: "",
                        remise: "",
                    },
                ],
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
            duplicate () {
                // Get the element
                var elem = document.querySelector('#element');

                // Create a copy of it
                var clone = elem.cloneNode(true);

                // Update the ID and add a class
                clone.id = 'elem2';
                this.tableLine++

                // Inject it into the DOM
                elem.after(clone);
            },
            chooseFile() {
                const input = document.querySelector("#input-file");
                input.click();
            },
            processFile(event) {
                this.choose = true;
                this.picture = event.target.files[0];
                if (event.target.files.length !== 0) {
                    const picturePath = URL.createObjectURL(this.picture);
                    const picture = document.querySelector("#logo-img");
                    picture.src = picturePath;
                } else {
                    const picture = document.querySelector("#logo-img");
                    picture.src = "";
                }
            },
            deletePicture() {
                this.choose = false;
                this.picture = "";
                const picture = document.querySelector("#logo-img");
                picture.src = "";
            },
            submit() {
                let data = new FormData();
                data.append("libelle", this.form.libelle);
                data.append("nom", this.form.nom);
                data.append("today_date", this.form.today_date);
                data.append("date_echeace", this.form.date_echeace);
                data.append("prix_unitaire", this.form.prix_unitaire);

                data.append("date_echeance", this.form.article_id);
                data.append("prix_unitaire", this.form.compte_id);
                data.append("date_echeance", this.form.bank_name);
                data.append("prix_unitaire", this.form.prix_unitaire);
                data.append("date_echeance", this.form.payment_method_code);

                data.append("prix_unitaire", this.form.taxe);
                data.append("date_echeance", this.form.pays);
                data.append("prix_unitaire", this.form.description);
                data.append("date_echeance", this.form.remise);
                console.log(data);

                this.$inertia.post(this.route("facture.store"), data);
            },

            add_client() {
                this.form.post(this.route("client.store"), {
                    onSuccess: () => {
                        this.form.reset();
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Client ajouté avec success",
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

            add(index) {
                this.forms.push({ name: "" });
            },
            remove(index) {
                this.forms.splice(index, 1);
                console.log(index);
            },

            addclient() {
                this.$inertia.get("/client");
            },
        },
        mounted() {
            $(".tagging").select2({
                tags: false,
                placeholder: "Selectionner",
                allowClear: true,
            }),
                $("#zero-config").DataTable({
                    dom:
                        "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    oLanguage: {
                        oPaginate: {
                            sPrevious:
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            sNext:
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                        },
                        sInfo: "Showing page _PAGE_ of _PAGES_",
                        sSearch:
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        sSearchPlaceholder: "",
                        sLengthMenu: "Results :  _MENU_",
                    },
                    stripeClasses: [],
                    lengthMenu: [7, 10, 20, 50],
                    pageLength: 7,
                });
        },

        components: {
            Link,
            AppLayout,
            JetButton,
            JetValidationErrors,
        },
    };
</script>
