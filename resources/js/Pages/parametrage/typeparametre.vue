<template>
     <app-layout>
        <div class="col-lg-8 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <h2 class="m-auto mx-5">Ajouter Type-Parametre</h2><br><br>
                        <div class="col-lg-12 col-12 mx-auto">
                            <form  @submit.prevent="createtypara" id="typeparametre" >
                                <jet-validation-errors class="text-center mb-4" />
                                <jet-validation-success class="text-center mb-4" />

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
        props: ['success_type'],

        data()
        {
            return {
                form:{
                    libelle:'',
                    description:'',
                    icon:'',
                    error:"veillez reessayer svp",
                    success_type: " rendbshhj",

                }
            }
        },
        methods:{
            createtypara()
            {
                let data = new FormData();
                data.append('libelle',this.form.libelle);
                data.append('description',this.form.description);
                data.append('icon',this.form.icon);
                //console.log(data);
                this.$inertia.post(this.route('typeparametre.store'),data);
                form.reset();
            },

        }
    }

</script>
