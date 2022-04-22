<template>
   <app-layout title="Dashboard">
        <div class="col-lg-9 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                            <jet-validation-errors class="text-center mb-4" />
                            <jet-validation-success class="text-center mb-4" />
                            <form @submit.prevent="submit">
                                <div class="form-group">

                                    <h2 class="text-center" style="margin-bottom:2rem" >Enregistrement de Projet</h2>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Date_debut<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only">date_debut</label>
                                                <input v-model="form.date_debut" id="nom" type="text" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div>
                                        <p>Description<span class="text-danger">*</span></p>
                                        <label for="comment" class="sr-only">Description</label>
                                            <div class="form-group" >
                                                <textarea class="form-control" rows="5" id="description" name="description" v-model="form.description"></textarea>
                                            </div>
                                        </div>


                                        <div class="text-center" style="margin-top:2rem">
                                            <jet-button :class="{ 'opacity-25, text-center': form.processing } " :disabled="form.processing">
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


//   import Offre from '@/Pages/Factures/Offre.vue'

export default {
    props:['clients'],

    components:{
        JetValidationErrors,
        JetValidationSuccess,
          JetButton,
          AppLayout,
        Head,
        Link
    },

    data() {
            return {
                form:{
                    libelle:'',
                    budget:'',
                    date_debut:'',
                    date_fin:'',
                    description:'',
                    status: '',

                },
                i:0,
            }
        },
    methods: {
        submit() {
            this.$inertia.post(this.route('projet.store'),this.form);
            form.reset();
        },

        destroy(id){
            this.$inertia.delete('/projet/destroy'+id);
        },

        // togglePassword:function(){
        //     this.password.type="text";
        // }

    }

}
</script>
