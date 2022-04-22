<template>
    <app-layout>
<!--
    'code',
        'libelle',
        'slug',
        'icone',
        'description',
        'type_parametre_id',
        'created_user',
        'updated_user',
        'status',
 -->
        <div class="col-lg-8 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                            <form @submit.prevent="createpara" id="typeparametre" >
                                <h2 class="m-auto mx-5">Attribution de permissions</h2><br><br>
                                <jet-validation-errors class="text-center mb-4" />
                                <div class="form-group">
                                    <div>
                                        <div class="row">
                                                <div class="col-lg-12">
                                                     <p>Selectionner un Role<span class="text-danger">*</span></p>
                                                    <select class="form-control" id="role" name="role" v-model="form.role"  >
                                                        <option v-for="datas in data" :key="datas.id" :value="datas.id"  > {{ datas.name }} </option>
                                                    </select><br/>
                                            </div>
                                        </div>

                                        <div class="row">
                                                <div class="col-lg-12">
                                                     <p>Cocher les permissions<span class="text-danger">*</span></p>
                                                <div>
                                                    <!-- <div v-for="permissions in permission" :key="permissions.id" class="form-check">
                                                         <input type="checkbox" :key="permissions.id" :value="permissions.id" name="permission[]" class="form-check-input" :id="permissions.id" v-model="form.permission">
                                                         <label class="form-check-label" for="defaultCheck1">
                                                          <b class="text-dark">  {{ permissions.name}}  </b>
                                                        </label>
                                                    </div>-->

                                                    <select class="form-control tagging" multiple="multiple" id="permission" name="permission[]" v-model="form.permission"  >
                                                        <option v-for="permissions in roles " :key="permissions.id" :value="permissions.id" >
                                                            {{ permissions.name}}
                                                            </option>
                                                    </select>



                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                    <div class="text-center">
                                        <input type="submit" name="email" class="mt-4 btn btn-primary">
                                    </div>
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

    export default{
        components:{
            Link,
            AppLayout,
            JetButton,
            JetValidationErrors
        },
        mounted(){
            var ss = $(".tagging").select2({
                tags: true,
            });
        },
        props: ['data','succes','permission'],
        data()
        {
            return {
                form:{
                    role:'',
                    permission:'',
                }
            }
        },
         methods:{
            createpara()
            {
                let data = new FormData();
                data.append('role',this.form.role);
                data.append('permission[]',this.form.permission);
                console.log(data);
                this.$inertia.post(this.route('rolepermission.store'),data);
                onFinish: () => this.form.reset('libelle', 'description','icon');
            },
        }
    }
 </script>
