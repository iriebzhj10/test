<template>
    <app-layout>
        <transition>
        <div class="col-lg-8 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <h2 class="m-auto mx-5">Ajouter Type-Parametre</h2><br><br>
                        <div class="col-lg-12 col-12 mx-auto">
                            <form  @submit.prevent="createtypara" id="typeparametre" >
                                <div class="form-group">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Libelle 1</p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="libelle" v-model="edit.libelle" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Icon<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only"></label>
                                                <input type="text" class="form-control border" name="icon" id="icon" placeholder="fa fa-home" v-model="edit.icone">
                                            </div>
                                        </div>
                                    </div><!-- end 1-->
                                    <div>
                                        <p>Description<span class="text-danger">*</span></p>
                                        <label for="comment" class="sr-only">Description</label>
                                        <div class="form-group" >
                                            <textarea class="form-control" rows="5" id="description" name="description" v-model="edit.description"></textarea>
                                        </div>
                                    </div><!-- end 2-->
                                    <div class="row">
                                            <!--<button class="Btn btn-primary" type="submit">Enregistrer</button>-->
                                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="update(edit)">
                                       Enregistrer
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
     import ValidationErrors from '@/Jetstream/ValidationErrors.vue'
    export default{
        components:{
            Link,
            Head,
            AppLayout,
            JetButton,
            ValidationErrors
        },
        props: ['edit'],
        data()
        {
            return {
                form:{
                    libelle:'',
                    description:'',
                    icon:'',

                }
            }
        },
        methods:{
            update(edit)
            {
                this.$inertia.patch('/type-parametre/update/'+edit.id,edit);

            },

        }
    }
 </script>
