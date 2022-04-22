<template>
    <app-layout>

        <div class="col-lg-10 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                            <form @submit.prevent="createpara" id="typeparametre" >

                                <jet-validation-errors class="text-center mb-4" />
                                <jet-validation-Success class="text-center mb-4" />

                                <div class="container">

                                <div class="title-box">
                                    <h1>Mes Creanciers</h1>
                                </div>

                                <Link class="btn btn-primary btn-nueva float-right mb-3" :href="route('creancier.create')"><b>+</b> Creer </Link><br/>

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
                                            <td>{{ i++ }}  </td>
                                             <td>{{ datas.libelle }}</td>
                                             <td>{{ datas.description }}</td>
                                             <td>{{ datas.icone }}</td>
                                             <td class="text-center"><Link class="btn btn-default btn-outline-dark mr-3" :href="'/parametre/edit/'+datas.id"><i class="icofont-edit bg-succes"> </i> </Link></td>
                                             <td class="text-center"> <button @click="destroy(datas.id)" class="btn btn-default btn-outline-dark btn-danger"><i class="icofont-ui-delete bg-danger"></i> </button></td>
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
        props: ['data','num'],
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
                console.log(data);
                this.$inertia.post(this.route('parametre.store'),data);
            },

            destroy:function(id){
                this.$inertia.delete('/parametre/destroy/'+id);
            },
        }
    }
 </script>
