<template>
     <app-layout>
        <div class="col-lg-8 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <h2 class="m-auto mx-5">Editer Parametre</h2><br><br>
                        <div class="col-lg-12 col-12 mx-auto">
                            <form  @submit.prevent="createtypara" id="typeparametre" >
                                <jet-validation-errors class="text-center mb-4" />
                                <jet-validation-Success class="text-center mb-4" />

                                <div class="form-group">
                                    <div class="row">
                                                <div class="col-lg-12">
                                                     <p>Type Parametre<span class="text-danger">*</span></p>
                                                    <select class="form-control" id="type" name="type" v-model="edit2.type" >
                                                        <option v-for="edits2 in edit2" :key="edits2.id" > {{ edits2.libelle }} </option>
                                                    </select><br/>
                                            </div>
                                        </div>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Libelle 1</p>
                                                <label for="e-text" class="sr-only">Libelle</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="libelle" v-model="edit.libelle" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Icon<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only"></label>
                                                <input type="text" class="form-control" name="icon" id="icon" placeholder="fa fa-home" v-model="edit.icon">
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
    </app-layout>
</template>




<script>
     import { Head, Link } from '@inertiajs/inertia-vue3'
     import AppLayout from '@/Layouts/AppLayout.vue'
     import JetButton from '@/Jetstream/Button.vue'
     import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
     import JetValidationSuccess from '@/Jetstream/ValidationSuccess.vue'




export default {
     components:{
            Head,
            Link,
            AppLayout,
            JetButton,
            JetValidationErrors,
            JetValidationSuccess
        },
        props: ['edit','edit2'],

        data()
        {
            return {
                form:{
                    type:'',
                    libelle:'',
                    description:'',
                    icon:'',
                    error:"veillez reessayer svp",
                    success_type: " rendbshhj",

                }
            }
        },
        methods:{
             update(edit,edit2)
            {

                this.$inertia.patch('/parametre/update/'+edit.id,edit,edit2);
            },

        }
    }

</script>
