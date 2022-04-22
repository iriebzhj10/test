<template>
    <app-layout>

        <div class="col-lg-10 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                                <jet-validation-errors class="text-center mb-4" />

                                <div class="container">

                                <div class="title-box">
                                    <h2>Departement</h2>
                                </div>
                                <form @submit.prevent="createtype" id="typeparametre" >
                                      <button type="button" class="btn btn-primary float-right mb-6" data-toggle="modal" data-target="#myModal"><b>+</b>  Creer </button>
                                </form>

                                <!-- <Link class="btn btn-primary btn-nueva float-right mb-3" :href="route('typeparametre.create')"><b>+</b> Creer </Link><br/> -->

                                <table class="table table-bordered grocery-crud-table table-hover mt-3">
                                    <thead>
                                    <tr>
                                        <th>N0 </th>
                                        <th>Libelle</th>
                                        <th>nombre_employe</th>
                                        <th>email</th>
                                        <th>contact</th>
                                        <th>Description</th>
                                        <th colspan="2">  </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(datas,i) in departements" :key="datas.id" >
                                            <td>{{ ++i }}  </td>
                                             <td>{{ datas.libelle }}</td>
                                             <td>{{ datas.nombre_employe }}</td>
                                             <td>{{ datas.email }}</td>
                                             <td>{{ datas.contact }}</td>
                                             <td>{{ datas.description }}</td>

                                             <td class="text-center">

                                                 <!-- <button type="button" class="btn btn-outline-success float-left" data-toggle="modal" :data-target="'#Editer'+data.id"> <i class="icofont-edit"> </i></button> -->
                                                  <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#edit'+datas.id" ><b>+</b> <i class="icofont-edit bg-succes"> </i>  </button>


                                                 <!-- <Link class="btn btn-default btn-outline-dark mr-3" :href="'/type-parametre/edit/'+datas.id"><i class="icofont-edit bg-succes"> </i> </Link> -->
                                                 </td>
                                             <td class="text-center"> <button @click="destroy(datas.id)" class="btn btn-default btn-outline-dark btn-danger"><i class="icofont-ui-delete bg-danger"></i> </button></td>
                                            <!--<td class="text-center"> <Link class="btn btn-default btn-outline-dark btn-danger" :href="'/type-parametre/destroy/'+datas.id "> <i class="icofont-ui-delete bg-danger"></i></Link> </td>-->
                                        </tr>

                                    </tbody>
                                    
                                </table>

                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




            <!-- The Modal creer    -->
                <!-- CREER -->
                    <div class="modal" id="myModal" >
                        <div class="modal-dialog  modal-xl">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                            <h3 text-white><center>Ajouter un Departement</center></h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form refs="anyName" @submit.prevent="createtype" >

                                    <jet-validation-errors class="text-center mb-4" />
                                    <jet-validation-Success class="text-center mb-4" />

                                    <div class="form-group">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Libelle </p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="libelle" v-model="form.libelle" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Nombre d'employees<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only"></label>
                                                <input type="text" class="form-control" name="montant" id="icon" placeholder="fa fa-home" v-model="form.nombre_employe ">
                                            </div>
                                        </div>
                                    </div><!-- end 1-->
                                     <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Contact</p>
                                                <label for="e-text" class="sr-only">Contact</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="date" v-model="form.contact" >
                                            </div>
                                             <div class="col-lg-6">
                                                <p>Email</p>
                                                <label for="e-text" class="sr-only">Email</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="date" v-model="form.email" >
                                            </div>
                                        </div>
                                    </div><!-- end 2-->
                                    <div>
                                        <p>Description<span class="text-danger">*</span></p>
                                        <label for="comment" class="sr-only">Description</label>
                                        <div class="form-group" >
                                            <textarea class="form-control" rows="5" id="description" name="description" v-model="form.description"></textarea>
                                        </div>
                                    </div><!-- end 2-->
                                    <div class="row">
                                            <!--<button class="Btn btn-primary" type="submit">Enregistrer</button>-->
                                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                       Valider
                                    </jet-button>
                                    </div>
                                </div>


                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                        </div>
                    </div>
                    <!-- The Modal CREER  -->
                <!-- CREER -->





                <!-- The Modal  editer -->
                <!-- editer -->
                
                    <div class="modal" :id="'edit'+edits.id" v-for="edits in departement_edits" :key="edits.id">
                        <div class="modal-dialog  modal-xl">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                            <h3 class="text-white"><center>Editer l'echeance </center></h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form refs="anyName" @submit.prevent="update(edits)">

                                    <jet-validation-errors class="text-center mb-4" />
                                    <jet-validation-Success class="text-center mb-4" />
                                    <div class="form-group">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Libelle </p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="libelle" v-model="edits.libelle" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Nombre d'employees<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only"></label>
                                                <input type="text" class="form-control" name="montant" id="icon" placeholder="fa fa-home" v-model="edits.nombre_employe ">
                                            </div>
                                        </div>
                                    </div><!-- end 1-->
                                     <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Contact</p>
                                                <label for="e-text" class="sr-only">Contact</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="date" v-model="edits.contact" >
                                            </div>
                                             <div class="col-lg-6">
                                                <p>Email</p>
                                                <label for="e-text" class="sr-only">Email</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="date" v-model="edits.email" >
                                            </div>
                                        </div>
                                    </div><!-- end 2-->
                                    <div>
                                        <p>Description<span class="text-danger">*</span></p>
                                        <label for="comment" class="sr-only">Description</label>
                                        <div class="form-group" >
                                            <textarea class="form-control" rows="5" id="description" name="description" v-model="edits.description"></textarea>
                                        </div>
                                    </div><!-- end 2-->
                                    <div class="row">
                                            <!--<button class="Btn btn-primary" type="submit">Enregistrer</button>-->
                                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                       Valider
                                    </jet-button>
                                    </div>
                                </div>



                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                        </div>
                    </div>
                    <!-- The Modal EDITER -->
                <!-- Editer -->























    </app-layout>
 </template>


 <script>
     import { Head, Link } from '@inertiajs/inertia-vue3'
     import AppLayout from '@/Layouts/AppLayout.vue'
     import JetButton from '@/Jetstream/Button.vue'
     import JetValidationSuccess from '@/Jetstream/ValidationSuccess.vue'
     import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'


    export default{
        components:{
            Link,
            AppLayout,
            JetButton,
            JetValidationErrors,
            JetValidationSuccess,

        },
        mounted(){console.log(data1)}, 
        props: ['departements','departement_edits','edit','data1'],
        data()
        {
            return {
                form:{
                    libelle:'',
                    description:'',
                    icon:'',
                    date:'',
                    montant:'',
                    nombre_employe:'',



                },
                 i:1,
            }
        },

         methods:{
            createtype()
            {
               
                this.$inertia.post(this.route('departement.store'),this.form);
            },

            destroyfff:function(id){
                this.$inertia.delete('/departement/destroy/'+id);
            },

            update(departement_edits){
               
                 this.$inertia.patch('/departement/update/{id}'+departement_edits.id,departement_edits);
                  console.log(echeancier);
            },
              destroy(id) {
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
                         this.$inertia.delete('/departement/destroy/'+id);
                        Swal.fire("Votre fichier a été supprimé.", "Succès");
                    }
                });
            },
        }
    }
 </script>
