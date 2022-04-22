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
                                                <input  type="text" placeholder="Enter un role ici !" class="form-control" name="name" v-model="form.name" >
                                            </div>
                                        </div>
                                    </div><br/><!-- end 1-->

                                    <div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Selectionner les permissions</p>
                                                <label for="name" class="sr-only">Permissions</label>
                                                <div >

                                                     <select class="form-control tagging" multiple="multiple"   id="liste" name="perm[]"  v-model="form.perm" >
                                                        <option v-for="permis in permissions" :key="permis.id" :value="permis.id" >{{permis.name}}</option>
                                                    </select>


                                                       <!-- <div v-for="role in roles" :key="role.id" >
                                                        <div v-for="permission in role.permissions" :key="permission.id">
                                                            {{ permission.name }}
                                                        </div>
                                                    </div> 


                                                    <div class="form-check-inline"   v-for="permis in permissions" :key="permis.id">
                                                         <label class="form-check-label text-dark">
                                                             <input type="checkbox" class="form-check-input" name="perm" v-model="form.check" >  {{permis.name}} <br/> 
                                                         </label>
                                                    </div> -->





                                                </div>
                                            </div>
                                        </div>
                                    </div><br/><!-- end 2-->




                                    <div class="row">
                                            <!--<button class="Btn btn-primary" type="submit">Enregistrer</button>-->
                                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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

        props: ['roles','permissions'],
        data()
        {
            return {
                form:{
                    name:'',
                    roles:'',
                    perm:[],
                    check:[],
                }
            }
        },
        methods:{

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
            },


        }
    }
 </script>
