<template>
    <!-- <Head title="Article" /> -->
    <app-layout title="Article">
        <div class="col-lg-12 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                            <!-- liste des articles de l'utilisateur connecté -->
                            <h3>
                                Liste des articles <button as="button" type="button" class="btn btn-primary btn-nueva float-right mb-3" data-toggle="modal" data-target="#myModal"><b>+</b> Ajouter</button><br />
                            </h3>
                            <!-- <jet-validation-success class="text-center mb-4" /> -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Libelle</th>
                                            <th>Type</th>
                                            <th>Coût de production</th>
                                            <th>Prix de vente</th>
                                            <th class="text-center" colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(article,i) in articles" :key="article.id">
                                            <td class="text-center">{{ ++i }}</td>
                                            <td>{{ article.libelle }}</td>
                                            <td v-if="article.type==='2'">Service</td>
                                            <td v-else-if="article.type==='1'">Produit</td>
                                            <td>{{article.prix_achat}}</td>
                                            <td>{{article.prix_vente}}</td>

                                            <td class="text-center">
                                                <a href="javascript:void(0);" data-toggle="modal" :data-target="'#edit'+article.id" data-placement="top" title="Edit">
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
                                                        class="feather feather-edit-2 edit-icon-color"
                                                    >
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                            <td class="text-center edit-icon-color">
                                                <a @click="destroy(article.id)" href="javascript:void(0);" role="button" data-toggle="tooltip" data-placement="top" title="delete">
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
                                                        class="feather feather-trash-2 trash-icon-color"
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

                            <!-- Modal creation de article -->

                            <div class="modal animate__animated animate__fadeInTopRight" id="myModal">
                                <div class="modal-dialog modal-xl">
                                    <div class="row">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header bg-indigo modal-header-border-bottom">
                                                <h3><center class="text-lavande">Créer un article</center></h3>
                                                <button type="button" class="close text-lavande" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <!-- <jet-validation-errors class="text-center mb-4"/> -->
                                                <!-- <jet-validation-success class="text-center mb-4" /> -->
                                                <!-- Liste des articles -->
                                                <form @submit.prevent="submit">
                                                    <div class="row m-auto mt-5">
                                                        <div class="col-lg-8 layout-spacing mt-3">
                                                            <div class="statbox widget box box-shadow">
                                                                <div class="widget-content widget-content-area">
                                                                    <div class="form-group">
                                                                        <div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <p>Libellé<span class="text-danger">*</span></p>
                                                                                    <label for="e-text" class="sr-only">Libellé</label>
                                                                                    <input id="libelle" type="text" placeholder="" class="form-control" v-model="form.libelle" />
                                                                                    <div class="text-danger" v-if="errors.libelle">{{ errors.libelle }}</div>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p>Type article<span class="text-danger">*</span></p>
                                                                                    <select
                                                                                        id="poids"
                                                                                        class="custom-select custom-select-lg"
                                                                                        style="padding-top: 0.75rem; padding-right: 1.25rem; padding-bottom: 0.3rem; padding-left: 1.25rem;"
                                                                                        v-model="form.type"
                                                                                    >
                                                                                        <option value="1">Produit</option>
                                                                                        <option value="2">Service</option>
                                                                                    </select>
                                                                                    <div class="text-danger" v-if="errors.type">{{ errors.type }}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div>
                                                                            <p>Description</p>
                                                                            <textarea
                                                                                name=""
                                                                                id="description"
                                                                                cols="30"
                                                                                rows="10"
                                                                                placeholder="Description du produit"
                                                                                class="w-100"
                                                                                style="border: 1px solid #bfc9d4;"
                                                                                v-model="form.description"
                                                                            >
                                                                            </textarea>
                                                                        </div>

                                                                        <div>
                                                                            <div class="form-row mb-4">
                                                                                <div class="col">
                                                                                    <p>Unité</p>
                                                                                    <select
                                                                                        id="poids"
                                                                                        class="custom-select custom-select-lg"
                                                                                        style="padding-top: 0.75rem; padding-right: 1.25rem; padding-bottom: 0.3rem; padding-left: 1.25rem;"
                                                                                        v-model="form.poids"
                                                                                    >
                                                                                        <option selected disabled>select</option>
                                                                                        <option value="1">Kg</option>
                                                                                        <option value="2">Mètre</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <p>Coût de production</p>
                                                                                    <label for="e-text" class="sr-only">Coût de production</label>
                                                                                    <input id="prix_achat" type="number" placeholder="" class="form-control" v-model="form.prix_achat" />
                                                                                    <div class="text-danger" v-if="errors.prix_vente">{{ errors.prix_vente }}</div>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p>Prix de vente<span class="text-danger">*</span></p>
                                                                                    <label for="e-text" class="sr-only">Prix de vente</label>
                                                                                    <input id="prix_vente" type="number" placeholder="" class="form-control" v-model="form.prix_vente" />
                                                                                    <div class="text-danger" v-if="errors.prix_vente">{{ errors.prix_vente }}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- <div>
                                                                    <p>Status du client<span class="text-danger">*</span></p>
                                                                    <div class="widget-content widget-content-area mt-0">
                                                                        <select class="custom-select custom-select-lg ">
                                                                            <option selected>Particulier</option>
                                                                            <option value="1">Entreprise</option>
                                                                        </select>
                                                                    </div>
                                                                </div> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 layout-spacing mt-3">
                                                            <div class="statbox widget box box-shadow">
                                                                <div class="widget-content widget-content-area">
                                                                    <div class="row">
                                                                        <div class="col" style="margin-bottom: 70px;">
                                                                            <div class="col-12 custom-file-container" data-upload-id="myFirstImage">
                                                                                <label>Image de votre article <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                                                                <label class="custom-file-container__custom-file">
                                                                                    <input type="file" class="custom-file-container__custom-file__custom-file-input" @change="recup_file" accept="image/*" id="image" />
                                                                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                                                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                                                                                </label>
                                                                                <div class="custom-file-container__image-preview"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <hr />
                                                                    <div class="row">
                                                                        <div class="col" style="margin-bottom: 7px;">
                                                                            <label for="basic-url"><p>Vidéo</p></label>
                                                                            <div class="input-group mb-4">
                                                                                <!-- <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon7">https://</span>
                                                                                </div> -->
                                                                                <input type="text" class="form-control" id="basic-url" v-model="form.lien_video" aria-describedby="basic-addon3" placeholder="lien d'une vidéo youtube" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="text-center">
                                                                    <br>
                                                                    <jet-button :class="{ 'opacity-25, text-center': form.processing } " :disabled="form.processing">
                                                                                Valider
                                                                    </jet-button>
                                                        </div> -->
                                                    </div>
                                                </form>
                                                <!-- Fin liste des articles -->
                                            </div>

                                            <!-- Modal footer -->
                                            <!-- <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                                        </div> -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" @click="submit()">Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--END Modal creation de article -->

                            <!--  Modal update d'article-->
                            <div v-for="article in articles_edit" :key="article.id">
                                <div class="modal animate__animated animate__zoomInDown" :id="'edit'+article.id">
                                    <div class="modal-dialog modal-xl">
                                        <div class="row">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header bg-indigo modal-header-border-bottom">
                                                    <h3 class="text center text-lavande"><center>Modifier un article</center></h3>
                                                    <button type="button" class="close text-lavande" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <!-- <jet-validation-errors class="text-center mb-4"/> -->
                                                    <!-- <jet-validation-success class="text-center mb-4" /> -->
                                                    <!-- Liste des articles -->
                                                    <form @submit.prevent="update(article)">
                                                        <div class="row m-auto mt-5">
                                                            <div class="col-lg-8 layout-spacing mt-3">
                                                                <div class="statbox widget box box-shadow">
                                                                    <div class="widget-content widget-content-area">
                                                                        <div class="form-group">
                                                                            <div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-lg-6">
                                                                                        <p>Libellé<span class="text-danger">*</span></p>
                                                                                        <label for="e-text" class="sr-only">Libellé</label>
                                                                                        <input id="libelle" type="text" placeholder="" class="form-control" v-model="article.libelle" />
                                                                                        <div class="text-danger" v-if="errors.libelle">{{ errors.libelle }}</div>
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <p>Type article<span class="text-danger">*</span></p>
                                                                                        <select
                                                                                            id="poids"
                                                                                            class="custom-select custom-select-lg"
                                                                                            style="padding-top: 0.75rem; padding-right: 1.25rem; padding-bottom: 0.3rem; padding-left: 1.25rem;"
                                                                                            v-model="article.type"
                                                                                        >
                                                                                            <option value="1">Produit</option>
                                                                                            <option value="2">Service</option>
                                                                                        </select>
                                                                                        <div class="text-danger" v-if="errors.type">{{ errors.type }}</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <p>Description</p>
                                                                                <textarea
                                                                                    name=""
                                                                                    id="description"
                                                                                    cols="30"
                                                                                    rows="10"
                                                                                    placeholder="Description du produit"
                                                                                    class="w-100"
                                                                                    style="border: 1px solid #bfc9d4;"
                                                                                    v-model="article.description"
                                                                                >
                                                                                </textarea>
                                                                            </div>

                                                                            <div>
                                                                                <div class="form-row mb-4">
                                                                                    <div class="col">
                                                                                        <p>Unité</p>
                                                                                        <select
                                                                                            id="poids"
                                                                                            class="custom-select custom-select-lg"
                                                                                            style="padding-top: 0.75rem; padding-right: 1.25rem; padding-bottom: 0.3rem; padding-left: 1.25rem;"
                                                                                            v-model="article.poids"
                                                                                        >
                                                                                            <option selected disabled>select</option>
                                                                                            <option value="1">Kg</option>
                                                                                            <option value="2">Mètre</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-6">
                                                                                        <p>Coût de production</p>
                                                                                        <label for="e-text" class="sr-only">Libellé</label>
                                                                                        <input id="prix_achat" type="number" placeholder="" class="form-control" v-model="article.prix_achat" />
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <p>Prix de vente<span class="text-danger">*</span></p>
                                                                                        <label for="e-text" class="sr-only">Prix de vente</label>
                                                                                        <input id="prix_vente" type="number" placeholder="" class="form-control" v-model="article.prix_vente" />
                                                                                        <div class="text-danger" v-if="errors.prix_vente">{{ errors.prix_vente }}</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- <div>
                                                                    <p>Status du client<span class="text-danger">*</span></p>
                                                                    <div class="widget-content widget-content-area mt-0">
                                                                        <select class="custom-select custom-select-lg ">
                                                                            <option selected>Particulier</option>
                                                                            <option value="1">Entreprise</option>
                                                                        </select>
                                                                    </div>
                                                                </div> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4 layout-spacing mt-3">
                                                                <div class="statbox widget box box-shadow">
                                                                    <div class="widget-content widget-content-area">
                                                                        <div class="row">
                                                                            <div class="col" style="margin-bottom: 70px;">
                                                                                <div class="col-12 custom-file-container" data-upload-id="myFirstImage2">
                                                                                    <label>Image de votre article <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                                                                    <label class="custom-file-container__custom-file">
                                                                                        <input type="file" class="custom-file-container__custom-file__custom-file-input" @change="recup_file" accept="image/*" id="image" />
                                                                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                                                                    </label>
                                                                                    <div class="custom-file-container__image-preview"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <hr />
                                                                        <div class="row">
                                                                            <div class="col" style="margin-bottom: 70px;">
                                                                                <label for="basic-url"><p>Lien vidéo</p></label>
                                                                                <div class="input-group mb-4">
                                                                                    <!-- <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon7">https://</span>
                                                                                    </div> -->
                                                                                    <input
                                                                                        type="text"
                                                                                        class="form-control"
                                                                                        id="lien_video"
                                                                                        v-model="article.lien_video"
                                                                                        aria-describedby="basic-addon3"
                                                                                        placeholder="https://www.youtube.com/watch?v=Gql7pZ6Bl6Y"
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="text-center">
                                                                    <br>
                                                                    <jet-button :class="{ 'opacity-25, text-center': form.processing } " :disabled="form.processing">
                                                                                Valider
                                                                    </jet-button>
                                                        </div> -->
                                                        </div>
                                                    </form>
                                                    <!-- Fin liste des articles -->
                                                </div>

                                                <!-- Modal footer -->
                                                <!-- <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                                                </div> -->
                                                <!-- <div class="modal-footer"> -->
                                                <!-- <button type="button" class="btn btn-primary"
                                                    @click="submit()">Enregistrer</button> -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" @click="update(article)">Enregistrer</button>
                                                </div>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Modal update de article  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    // import JetSideBar from "@/Jetstream/SideBar.vue";
    import { Head, Link } from "@inertiajs/inertia-vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import JetButton from "@/Jetstream/Button.vue";
    // import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
    // import JetValidationSuccess from "@/Jetstream/ValidationSuccess.vue";

    export default {
        props: ["articles", "articles_edit", "errors"],

        mounted() {
            var firstUpload = new FileUploadWithPreview("myFirstImage");
            var firstUpload = new FileUploadWithPreview("myFirstImage2");
            $(".tagging").select2({
                tags: true,
            });
        },

        components: {
            Head,
            Link,
            JetButton,
            AppLayout,
            // JetValidationErrors,
            // JetValidationSuccess,
        },
        data() {
            return {
                form: this.$inertia.form({
                    libelle: "",
                    description: "",
                    poids: "",
                    type: "",
                    prix_achat: "",
                    prix_vente: "",
                    lien_video: "",
                    image: "",
                }),
                i: 0,
            };
        },

        methods: {
            submit() {
                let data = new FormData();
                data.append("libelle", this.form.libelle);
                data.append("description", this.form.description);
                data.append("poids", this.form.poids);
                data.append("type", this.form.type);
                data.append("prix_achat", this.form.prix_achat);
                data.append("prix_vente", this.form.prix_vente);
                data.append("image", this.form.image);
                data.append("lien_video", this.form.lien_video);
                // console.log(this.form);
                // console.log(data);

                this.$inertia.post(this.route("article.store"), data);

                this.form.post(this.route("article.store"), {
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
            recup_file(e) {
                this.form.image = e.target.files[0];
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
                        this.$inertia.delete("/article/destroy/" + id);
                        Swal.fire("Votre fichier a été supprimé.", "Succès");
                    }
                });
            },
            edit(id) {
                this.form.get("/article/edit" + id);
            },

            update(articles) {
                let data = new FormData();
                data.append("libelle", articles.libelle);
                data.append("description", articles.description);
                data.append("poids", articles.poids);
                data.append("type", articles.type);
                data.append("prix_achat", articles.prix_achat);
                data.append("prix_vente", articles.prix_vente);
                data.append("image", articles.image);
                data.append("lien_video", articles.lien_video);

                // console.log(articles);

                this.$inertia.patch("/article/update/" + articles.id, articles);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Article modifié avec success",
                    showConfirmButton: false,
                    timer: 1500,
                });
            },
        },
    };
</script>
