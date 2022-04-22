<template>
    <app-layout>
        <transition>
        <div class="col-lg-8 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <h2 class="m-auto mx-5">Creation de Role</h2><br><br>
                        <div class="col-lg-12 col-12 mx-auto">
                            <form  @submit.prevent="createrole" id="role" method="POST">
                                <div class="form-group">
                                    <jet-validation-errors class="text-center mb-4" />
                                    <jet-validation-success class="text-center mb-4" />

                                    <div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Role</p>
                                                <label for="name" class="sr-only">Role</label>
                                                <input  type="text" placeholder="Enter un role ici !" class="form-control" name="name" v-model="edit.name" >
                                            </div>
                                        </div>
                                    </div><br/><!-- end 1-->
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Selectionner les permissions</p>
                                                <label for="name" class="sr-only">Permissions</label>
                                                <div >

                                                     <select class="form-control tagging" multiple="multiple"   id="liste" name="perm[]"  v-model="edit2.perm" >
                                                        <option v-for="edits2 in edit2" :key="edits2.id" :value="edits2.id" >{{edits2.name}}</option>
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




                                    <div class="row">
                                            <!--<button class="Btn btn-primary" type="submit">Enregistrer</button>-->
                                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="update(edit,edit2)">
                                       Valider
                                    </jet-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </transition>
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

        props: ['edit','edit2'],
        data()
        {
            return {
                form:{
                    name:'',
                    roles:'',
                    perm:[],
                }
            }
        },
        methods:{

            update(edit,edit2)
            {
                this.$inertia.patch('/role/update/'+edit.id,edit,edit2);
            },


        }
    }
 </script>
