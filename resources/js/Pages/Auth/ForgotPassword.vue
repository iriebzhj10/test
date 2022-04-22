<template>
    <Head title="Mot de passe oublié" />

    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>
        
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <div v-if="status" class="alert alert-success mb-4 font-medium text-sm text-green-600">
                            {{ status }}
                        </div>
                        
                 <jet-validation-errors class="text-center mb-4" />
                        <h4 class=" text-indigo">Recuperer mon mot de passe</h4>
                           <form @submit.prevent="submit">
                            <div class="form">
                             <div id="email-field" class="form-group input row">
                                    <div class="col-2 pt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                    </div>
                                    <div class="col-10">
                                        <jet-input id="email" type="email" class="mt-1 block form-control" placeholder="email" v-model="form.email"  />
                                     
                                    </div>
                                </div>
                              
                                <div class="text-center justify-content-between">
                                    <div class="field-wrapper mt-4 row">
                                        <div class="col-2">
                                            <input type="hidden" name="" id="">
                                        </div>
                                        <div class="flex items-center justify-end mt-1 col-10 ">
                                            <jet-button class="mb-3 " :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                              Valider
                                            </jet-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!-- <div class="block mt-4">
                <label class="flex items-center">
                    <jet-checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div> -->
    </jet-authentication-card>
</template>

<script>
    import { Head } from '@inertiajs/inertia-vue3';
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

    export default {
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors
        },

        props: {
            status: String,
            errors: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.email'))
            }
        }
    }
</script>
