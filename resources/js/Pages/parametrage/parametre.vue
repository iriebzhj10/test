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
                                <h2 class="m-auto mx-5">Ajouter parametre</h2><br><br>
                                <jet-validation-errors class="text-center mb-4" />
                                <jet-validation-success class="text-center mb-4" />
                                <div>

                                </div>
                                <div class="form-group">
                                    <div>
                                        <div class="row">
                                                <div class="col-lg-12">
                                                     <p>Type Parametre<span class="text-danger">*</span></p>
                                                    <select class="form-control" id="type" name="type" v-model="form.type" >
                                                        <option v-for="datas in data" :key="datas.id" > {{ datas.libelle }} </option>
                                                    </select><br/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Libelle<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">libelle</label>
                                                <input id="libelle" name="libelle" type="text" placeholder=""  v-model="form.libelle"   class="form-control"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Icon<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">Icon</label>
                                                <input id="icon" name="icon" type="text" placeholder=""  v-model="form.icon"   class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                        <p>Description<span class="text-danger">*</span></p>
                                        <label for="comment" class="sr-only">Description</label>
                                        <div class="form-group" >
                                            <textarea class="form-control" v-model="form.description" rows="5" id="description" name="description"></textarea>
                                        </div>
                                    </div><!-- end 2-->
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
      import JetValidationSuccess from '@/Jetstream/ValidationSuccess.vue'

    export default{
        components:{
            Link,
            AppLayout,
            JetButton,
            JetValidationErrors,
            JetValidationSuccess
        },
        props: ['data'],
        data()
        {
            return {
                form:{
                    type:'',
                    libelle:'',
                    description:'',
                    icon:'',
                }
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
                onFinish: () => this.form.reset('libelle', 'description','icon');
            },
        }
    }
 </script>
