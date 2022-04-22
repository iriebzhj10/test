<template>
    <app-layout>

        <div class="col-lg-10 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                            <form @submit.prevent="createpara" id="parametre" >

                                <jet-validation-errors class="text-center mb-4" />
                                <jet-validation-Success class="text-center mb-4" />

                                <div class="container">

                                <div class="title-box">
                                    <h1>Liste des parametres</h1>
                                </div>

                                <Link class="btn btn-primary btn-nueva float-right mb-3" :href="route('parametre.create')" ><b>+</b> Creer </Link><br/>
                                <!-- v-if="$page.props.can.create" -->

                                 <!--
                                <table class="table table-bordered grocery-crud-table table-hover mt-3">
                                    <thead>
                                    <tr>
                                        <th>N0 </th>
                                        <th>Libelle</th>
                                        <th>Description</th>
                                        <th>Icone</th>
                                        <th colspan="2" class="text-center"> Action  </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(datas,i) in data" :key="datas.id" >
                                            <td>{{ ++i }}  </td>
                                             <td>{{ datas.libelle }}</td>
                                             <td>{{ datas.description }}</td>
                                             <td>{{ datas.icone }}</td>
                                             <td class="text-center"><Link class="btn btn-default btn-outline-success mr-3" :href="'/parametre/edit/'+datas.id"><i class="icofont-edit"> </i> </Link></td>
                                             <td class="text-center"> <button @click="destroy(datas.id)" class="btn btn-default btn-outline-red btn-danger"><i class="icofont-ui-delete"></i> </button></td>
                                        </tr>

                                    </tbody>
                                </table>-->
                                </div><br/>
                                



                                
                            </form>

                           

                            





                            <!-- Stack the columns on mobile by making one full-width and the other half-width {{ data1.libelle }}  v-for="data1 in resultat" :key="data1.id"  @click="destroy(datas.id)"      <i class="icofont-ui-delete bg-danger"></i>  -->
                            <div class="row">
                                <div class="col-12 col-md-3">

                                    <div class="btn-group-vertical border">
                                        <!-- <a class="btn btn-primary btn-lg active" role="button" aria-pressed="true" v-for="data1 in data_1" :key="data1.id" :href="'/?parametre='+ data1.id"  > {{ data1.libelle }} </a> -->
                                          <button v-for="data1 in data_1" :key="data1.id"  @click="searchpara(data1.id)" class="btn btn-default btn-outline-dark btn-danger">{{ data1.libelle }} </button>
    
                                          <br/>
                                    </div>

                                </div>

                                <div class="col-6 col-md-9"  >
                                    <div class="col-6 col-md-9"   >

                                                hkjhjhkjhkjhvkxjhv hhjdgjhgh
                                                
                                                <div v-for="data1 in resultat" :key="data1.id">
                                                        {{ data1.libelle }} 
                                                </div>

                                    </div>
                                </div>

                            </div>






                             <div class="col-6 col-md-9"  >
                                 
                                    <div class="col-6 col-md-9"   >

                                                hkjhjhkjhkjhvkxjhv hhjdgjhghb
                                                
                                                 <div v-for="data1 in resultat" :key="data1.id">
                                                        {{ data1.libelle }} 
                                                </div>

                                    </div>
                                </div>










                            <!-- <div id="accordion">


                                <div class="card"  v-for="data1 in data_1" :key="data1.id">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                        
                                            <input type="hidden" v-model="data1.id"/>
                                            <button class="btn btn-link" data-toggle="collapse" :data-target="'#collapseOne'+data1.id"  aria-expanded="true" aria-controls="collapseOne">
                                            {{ data1.libelle }} #1
                                            </button>
                                        
                                    </h5>
                                    </div>

                                    <div :id="'collapseOne'+data1.id" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        

                                        <div v-for="data2 in param" :key="data2.id">
                                             {{ data2.libelle }}jojojojojojoojojojojojojojo

                                           
                                        </div>

                                    </div>
                                    </div>
                                </div>

                              

                                


                            </div> -->

























































































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

        props: ['data','num','data_1','param','solution','lol ','resultat'],
        data()
        {
            return {

                    name:'',
                    roles:'',
                    perm:[],
                    i:1,

            }
        },



         methods:{
            createpara()
            {
                let data = new FormData();
                data.append('type',this.form.type);
                data.append('libelle',this.form.libelle);
                data.append('description',this.form.description);
                data.append('icon',this.form.icon);
                //console.log(data);
                this.$inertia.post(this.route('parametre.store'),data);
            },

            receuillirtypepara(id,data_1)
            {
                this.$inertia.post('/parametre/'+id,data_1);
                console.log(data_1);
            },

            searchpara(id,data_1)
            {
                this.$inertia.get('/parametre/'+id,data_1);
                console.log(data_1);
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
                         this.$inertia.delete('/parametre/destroy/'+id);
                        Swal.fire("Votre fichier a été supprimé.", "Succès");
                    }
                });
            },

        }
    }
 </script>
