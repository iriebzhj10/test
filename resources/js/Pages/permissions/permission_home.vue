<template>
    <app-layout>
        <div class="col-lg-10 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                            <!-- <jet-validation-errors class="text-center mb-4" />
                            <jet-validation-Success class="text-center mb-4" /> -->
                            <form @submit.prevent="createpara" id="typeparametre">
                                <!-- <jet-validation-success class="text-center mb-4" /> -->

                                <div class="container">
                                    <div class="title-box">
                                        <h1>Liste des permissions</h1>
                                    </div>

                                    <button type="button" class="btn btn-primary float-right mb-2" data-toggle="modal" data-target="#myModal"><b>+ </b>Ajouter</button>
                                    <!-- <Link class="btn btn-primary btn-nueva float-right mb-3" data-toggle="modal" data-target="#myModal" :href="route('permission.create')"><b>+</b> Creer </Link><br/> -->

                                    <table class="table table-bordered grocery-crud-table mt-3">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Libelle</th>
                                                <th colspan="2" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(permission,i) in permissions" :key="permission.id">
                                                <td class="text-center">{{ ++i }}</td>
                                                <td>{{ permission.name }}</td>
                                                <td class="text-center">
                                                    <!-- :href="'/permission/edit/'+permission.id" -->
                                                    <button type="button" class="btn btn-outline-success" data-toggle="modal" :data-target="'#Editer'+permission.id"> <i class="icofont-edit"> </i></button>
                                                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Editer"><b>+</b>  laisnew </button>-->
                                                    <!-- <Link type="button" class="btn btn-default btn-outline-dark mr-3 btn btn-primary" data-toggle="modal" data-target="#myModale" :href="'/permission/edit/'+permission.id"><i class="icofont-edit bg-succes"> </i> </Link> -->
                                                </td>
                                                <td class="text-center">
                                                    <button @click="destroy(permission.id)" class="btn btn-outline-danger"><i class="icofont-ui-delete"></i></button>
                                                </td>

                                              










                                                <!-- <td class="text-center"> <button @click="destroy(datas.id)" class="btn btn-default btn-outline-dark btn-danger"><i class="icofont-ui-delete bg-danger"></i> </button></td>-->
                                                <!--<td class="text-center"> <Link class="btn btn-default btn-outline-dark btn-danger" :href="'/type-parametre/destroy/'+datas.id "> <i class="icofont-ui-delete bg-danger"></i></Link> </td>-->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Modal CREER -->
        <!-- CREER -->
        <div class="modal" id="myModal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                        <h3><center class="text-lavande">Créer une Permission</center></h3>
                        <button type="button" class="close text-lavande" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form refs="anyName" @submit.prevent="createpermission">
                            <jet-validation-errors class="text-center mb-4" />
                            <jet-validation-Success class="text-center mb-4" />

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Entrer votre permission" v-model="form.name" />
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    
                </div>
            </div>
        </div>


            <!-- The Modal EDITER    -->
        <!-- EDITER -->
        <div class="modal" :id="'Editer'+permission.id" v-for="permission in permissions_edit" :key="permission.id" >
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                        <h3><center class="text-lavande">Editer une permission </center></h3>
                        <button type="button" class="close text-lavande" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form refs="anyName" @submit.prevent="updatepermission(permission)">
                            <jet-validation-errors class="text-center mb-4" />
                            <jet-validation-Success class="text-center mb-4" />

                            <div class="form-group">
                                <label for="exampleInputEmail1">Modifier la permission </label>
                                <input type="text" class="form-control" placeholder="Entrer votre permission" v-model="permission.name" />
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    
                </div>
            </div>
        </div>
        <!-- The Modal EDITER -->
        <!-- EDITER -->



    


    </app-layout>
</template>

<script>
    import { Head, Link } from "@inertiajs/inertia-vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import JetButton from "@/Jetstream/Button.vue";
    import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
    import JetValidationSuccess from "@/Jetstream/ValidationSuccess.vue";
    import Input from "../../Jetstream/Input.vue";

    export default {
        components: {
            Link,
            AppLayout,
            JetButton,
            JetValidationErrors,
            JetValidationSuccess,
            Input,
        },
        props: ["permissions", "permissions_edit", "edit"],

        data() {
            return {
                form: {
                    name: "",
                },
                i: 0,
            };
        },

        methods: {
            createpermission() {
                let data = new FormData();
                data.append("name", this.form.name);
                this.$inertia.post(this.route("permission.store"), data);

                cosnsole.log(data);
                
                onSuccess: () => this.form.reset();
            },

            editerpermission(event) {
                let data = new FormData();
                data.append("name", this.form.name);
                this.$inertia.post(this.route("/permission/edit/" + permission.id), data);
                event.target.reset();
            },
            updatepermission(permissions) {
                this.$inertia.patch("/permission/update/" + permissions.id, permissions);
                console.log(permissions);
            },

            destroyff: function (id) {
                this.$inertia.delete("/permission/destroy/" + id);
            },destroy(id) {
                Swal.fire({
                    title: "Es-tu sûr?",
                    text: "Vous ne pourrez pas revenir en arrière !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085D6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, supprimez-le !",
                    cancelButtonText: "Annuler",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$inertia.delete("/permission/destroy/" + id);
                        Swal.fire("Votre fichier a été supprimé.", "Succès");
                    }
                });
            },

        },
    };
</script>
