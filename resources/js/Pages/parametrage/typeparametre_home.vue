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
                                    <h2>type parametre</h2>
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
                                        <th>Description</th>
                                        <th>Icone</th>
                                        <th colspan="2">  </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(datas,i) in data" :key="datas.id" >
                                            <td>{{ ++i }}  </td>
                                             <td>{{ datas.libelle }}</td>
                                             <td>{{ datas.description }}</td>
                                             <td>{{ datas.icone }}</td>

                                             <td class="text-center">

                                                 <!-- <button type="button" class="btn btn-outline-success float-left" data-toggle="modal" :data-target="'#Editer'+data.id"> <i class="icofont-edit"> </i></button> -->
                                                  <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#edit'+datas.id" ><b>+</b> <i class="icofont-edit bg-succes"> </i>  </button>




                                                 <!-- <Link class="btn btn-default btn-outline-dark mr-3" :href="'/type-parametre/edit/'+datas.id"><i class="icofont-edit bg-succes"> </i> </Link> -->
                                                 </td>

                                               <td class="text-center"> 
                                                   <button @click="destroy(datas.id)" class="btn btn-default btn-outline-dark btn-danger"><i class="icofont-ui-delete bg-danger"></i> </button>
                                             
                                                     <!-- Button trigger modal -->
                                                  <!-- <button type="button" class="btn btn-default btn-outline-dark btn-danger" data-toggle="modal" :data-target="'#exampleModalCenter'+datas.id">
                                                         <i class="icofont-ui-delete bg-danger"></i> 
                                                     </button> -->
                                             
                                             </td>
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
                            <h3 class="text-white"><center>Ajouter un type parametre</center></h3>
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
                                                <p>Libelle 1</p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="libelle" v-model="form.libelle" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Icon<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only"></label>
                                                <input type="text" class="form-control" name="icon" id="icon" placeholder="fa fa-home" v-model="form.icon">
                                            </div>
                                        </div>
                                    </div><!-- end 1-->
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
                    <!-- The Modal CREER TYPE-PARAMETRE  -->
                <!-- CREER -->





                <!-- The Modal  editer  TYPE-PARAMETRE -->
                <!-- editer -->
                
                    <div class="modal" :id="'edit'+edits.id" v-for="edits in data" :key="edits.id">
                        <div class="modal-dialog  modal-xl">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                            <h3 class="text-white"><center>Editer Type parametre </center></h3>
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
                                                <p>Libelle 1</p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="libelle" v-model="edits.libelle" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Icon<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only"></label>
                                                <input type="text" class="form-control" name="icon" id="icon" placeholder="fa fa-home" v-model="edits.icone">
                                            </div>
                                        </div>
                                    </div><!-- end 1-->
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
                <!-- CREER -->











           















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
        // mounted(){console.log(data1)}, 
        props: ['data','num','edit','data1'],
        data()
        {
            return {
                form:{
                    libelle:'',
                    description:'',
                    icon:'',


                },
                 i:1,
            }
        },

         methods:{
            createtype()
            {
                let data = new FormData();
                data.append('libelle',this.form.libelle);
                data.append('description',this.form.description);
                data.append('icon',this.form.icon);
                console.log(data);
                this.$inertia.post(this.route('typeparametre.store'),data);
            },

             destroyddd:function(id){
                this.$inertia.delete('/type-parametre/destroy/'+id);
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
                        this.$inertia.delete('/type-parametre/destroy/'+id);
                        Swal.fire("Votre fichier a été supprimé.", "Succès");
                    }
                });
            },

            update(data){
               
                 this.$inertia.patch('/type-parametre/update/{id}'+data.id,data);
                  console.log(data);
            },
        }
    }
 </script>
