<template>
    <app-layout>

        <div class="col-lg-10 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                            <!-- <jet-validation-errors class="text-center mb-4" /> -->
                            <form @submit.prevent="createpara" id="typeparametre" >


                                <div class="container">

                                <div class="title-box">
                                    <h1>Roles</h1>
                                </div>

                                <button type="button" class="btn btn-primary" data-toggle="modal"   data-target="#Creer"><b>+</b>  Creer1 </button>
                                <!--<Link class="btn btn-primary btn-nueva float-right mb-3" @click="direct()"  :href="route('role.create')"><b>+</b> Creer </Link><br/>-->

                                <table class="table table-bordered grocery-crud-table table-hover mt-3">
                                    <thead>
                                    <tr>
                                        <th>N0 </th>
                                        <th>Libelle</th>
                                        <th colspan="2"> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(role,i) in roles" :key="role.id" >
                                            <td> {{ i++ }}  </td>
                                             <td>{{ role.name }}</td>
                                             <td class="text-center">
                                                  <!-- <button type="button" class="btn btn-primary mr-2" data-toggle="modal" :data-target="'#view'+role.id" ><b> <i class="icofont-eye bg-succes"> </i>   </b> </button>--> 
                                                 <!-- :data-target="'#Editer'+permission.id -->
                                                 <button type="button" class="btn btn-primary mr-2" data-toggle="modal" :data-target="'#Update'+role.id" ><b>+</b> <i class="icofont-edit bg-succes"> </i>  </button>
                                                <!--  <Link class="btn btn-default btn-outline-dark mr-3" :href="'/role/edit/'+role.id"><i class="icofont-edit bg-succes"> </i> </Link>--> 
                                                 <button @click="destroy(role.id)" class="btn btn-default btn-outline-dark btn-danger"><i class="icofont-ui-delete bg-danger"></i> </button>

                                                </td>

                                            <!-- <td v-for="permission in role.permissions" :key="permission.id">
                                                {{ permission.name }}
                                             </td> -->



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
            <div class="modal" id="Creer" v-for="(permission) in permissions" :key="permission.id" >
                <div class="modal-dialog  modal-md">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header modal-header-border-bottom text-white bg-indigo">
                    <h3 class="text-white"><center>Creer une Role</center></h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form refs="anyName" @submit.prevent="createrole">


                            <jet-validation-errors class="text-center mb-4" />
                            <jet-validation-Success class="text-center mb-4" />


                            <!-- <div class="form-group">
                                <label for="exampleInputEmail1">Creer une permission</label>
                                <input type="text" class="form-control"   placeholder="Entrer votre permission" >
                                <-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> ->
                            </div> -->




                                    <div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Role</p>
                                                <label for="name" class="sr-only">Role</label>
                                                <input  type="text" placeholder="Enter un role ici !" class="form-control" name="name" v-model="form.name" >
                                            </div>
                                        </div>
                                    </div>
                                    <br/><!-- end 1-->
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Selectionner les permissions</p>
                                                <label for="name" class="sr-only">Permissions</label>
                                                <div >



                                                     <select class="form-control tagging" multiple="multiple"   id="liste" name="perm[]"  v-model="form.perm" >
                                                        <option v-for="permis in permissions" :key="permis.id" :value="permis.id" > {{permis.name}} </option>
                                                    </select>



                                                     <!-- <div v-for="role in roles" :key="role.id" >
                                                        <div v-for="permission in role.permissions" :key="permission.id">
                                                            {{ permission.name }}
                                                        </div>
                                                    </div> -->



<!--
                                                    <div class="form-check-inline">
                                                         <label class="form-check-label">
                                                             <input type="checkbox" class="form-check-input" v-for="permis in permissions" :key="permis.id" :value="permis.id" name="perm">
                                                         </label>
                                                    </div> -->





                                                </div>
                                            </div>
                                        </div>
                                    </div><br/><!-- end 2-->









                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
                </div>
            </div>






              <!-- The Modal Update -->
          <!-- Update -->
            <div v-for="role in roles" :key="role.id" >
                <div class="modal" :id="'Update'+role.id"  >
                    <div class="modal-dialog  modal-md">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                             <h5 class="text-white"><center>Editer l'attribution de permission a un Role</center></h5>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <form refs="anyName" @submit.prevent="updaterole(role)">


                                <jet-validation-errors class="text-center mb-4" />
                                <jet-validation-Success class="text-center mb-4" />
                                                            <!-- v-model="edit.name"   -->
                                                            <!-- v-model="edit.name"   roles  ***** role.name****     v-for="role in roles" :key="role.id" -->
                                            <div class="row" >
                                                <div class="col-lg-12"  >
                                                    <p><b>Role</b></p>
                                                    <label for="name" class="sr-only">Role</label>
                                                    <input  type="text" placeholder="Enter un role ici !" class="form-control" name="role.name" v-model="role.name "  >
                                                </div>
                                            </div><br/><!-- end 1-->


                                        <div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p><b>Selectionner les permissions</b></p>
                                                    <label for="name" class="sr-only">Permissions</label>
                                                    <div >
                                                        <select class="form-control tagging" multiple="multiple"   id="list" name="perm[]"  v-model="role.perm" >
                                                            <option v-for="permis in permissions" :key="permis.id" :value="permis.id" > {{permis.name}} </option>
                                                        </select>
                                                        <!-- <div v-for="role in roles" :key="role.id" >
                                                            <div v-for="permission in role.permissions" :key="permission.id">
                                                                {{ permission.name }}
                                                            </div>
                                                        </div> -->
                   <!--
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" v-for="permis in permissions" :key="permis.id" :value="permis.id" name="perm">
                                                            </label>
                                                        </div> -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div><br/><!-- end 2-->

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                    </div>
                </div>
            </div>




      <!-- The Modal view -->
          <!-- view -->
            <div v-for="role in roles" :key="role.id" >
                <div class="modal" :id="'view'+role.id"  >
                    <div class="modal-dialog  modal-md">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                             <h3 class="text-white"><center>permission du Role >> {{role.name}} </center></h3>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <form refs="anyName" @submit.prevent="updaterole(role)">


                                <jet-validation-errors class="text-center mb-4" />
                                <jet-validation-Success class="text-center mb-4" />
                                                            <!-- v-model="edit.name"   -->
                                                            <!-- v-model="edit.name"   roles  ***** role.name****     v-for="role in roles" :key="role.id" -->
                                            <div class="row" >
                                                <div class="col-lg-12"  >
                                                    <p><b>Role</b></p>
                                                    <label for="name" class="sr-only">Role</label>
                                                    <input  type="text" placeholder="Enter un role ici !" class="form-control" name="role.name" v-model="role.name " disabled  >
                                                </div>
                                            </div><br/><!-- end 1-->


                                        <div>
                                            <p><b>Selectionner les permissions</b></p>
                                             <label for="name" class="sr-only">Permissions</label>
                                            <div class="row"  v-for="permis in permissions" :key="permis.id" :value="permis.id" >
                                                <ul>
                                                    <li> {{permis.name}} </li> 
                                                </ul>

                                            </div>
                                        </div><br/><!-- end 2-->
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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




    export default{
        components:{
            Link,
            AppLayout,
            JetButton,
            JetValidationErrors,
            JetValidationSuccess
        },
        mounted(){
            var ss = $(".tagging").select2({
                tags: true,
            });
        },
        props: ['roles','permissions','edit','edit2'],
        data(){
            return{
                 form:{
                    name:'',
                    roles:'',
                    perm:[],
                },
                i:1,
            }
        },

         methods:{
            createpara()
            {

            },
            direct()
            {
                this.$inertia.get(this.route('role.create'),data);
            },

            destroygg:function(id){
                this.$inertia.delete('role/destroy/'+id);
            },

              createrole()
            {


                //var liste, texte;
                // liste = document.getElementById("liste");
                //texte = liste.options[liste.selectedIndex].text;

                var selectedList = [],countno=[],
                    selectBox = document.getElementById("liste"),
                    i;

                for (i=0; i < selectBox.length; i++)
                {
                    if (selectBox[i].selected)
                    {
                       // selectedList.push(selectBox[i]);

                      // selectedList.push(selectBox[i].text);
                       //selectedList.add(String(selectBox[i].text));
                       selectedList.push((selectBox[i].text).toString());
                       countno.push(i);

                    }
                }

               // console.log(selectedList);

                let data = new FormData();
                data.append('name',this.form.name);
                data.append('perm[]',selectedList.toString());
                data.append('countno',countno);
                 console.log(data);

                this.$inertia.post(this.route('role.store'),data);
                onSuccess: () => this.form.reset()
            },




            updaterole(role)
            {

                   var selectedList = [],countno=[],
                    selectBox = document.getElementById("list"),
                    i;

                 for (i=0; i < selectBox.length; i++)
                {
                    if (selectBox[i].selected)
                    {
                       // selectedList.push(selectBox[i]);

                      // selectedList.push(selectBox[i].text);
                       //selectedList.add(String(selectBox[i].text));
                       selectedList.push((selectBox[i].text).toString());
                       countno.push(i);

                    }
                }

                let data = new FormData();
                data.append('name',role.name);
                data.append('perm[]',selectedList.toString());
                data.append('countno',countno);
                 console.log(data);

                console.log(selectedList);
                console.log(data);

                this.$inertia.patch('/role/update/'+role.id,role);

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
                         this.$inertia.delete('role/destroy/'+id);
                        Swal.fire("Votre fichier a été supprimé.", "Succès");
                    }
                });
            },
        }
    }
 </script>
