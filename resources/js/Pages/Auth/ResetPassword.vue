<template>
    <Head title="réinitialiser mot de passe" />

 
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>
      
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                 <jet-validation-errors class="text-center mb-4" />
                   <div v-if="status" class=" alert alert-success mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>
                        <h3 class="montserrat text-indigo text-center">Réinitialiser <br> mot de passe</h3>
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
                                <div id="password-field" class="form-group mb-2 row">
                                    <div class="col-2 pt-2 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    </div>
                                    <div class="col-10">
                                        <input id="password"  type="password" class="form-control" placeholder="Password" v-model="form.password">
                                    </div>
                                </div>
                                <div class="text-center justify-content-between">
                                    <div class="row">
                                        <div class="field-wrapper toggle-pass col-12 text-center mt-3">
                                            <p class="d-inline-block">Voir le mot de passe</p>
                                            <label class="switch s-primary">
                                                <input type="checkbox"  @click="showPassword()" class="d-none">
                                                <span  class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="field-wrapper mt-4 row">
                                        <div class="col-2">
                                            <input type="hidden" name="" id="">
                                        </div>
                                        <div class="flex items-center justify-end mt-1 col-10 ">
                                            <jet-button class="mb-3 " :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                              réinitialiser
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
            email: String,
            token: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    token: this.token,
                    email: this.email,
                    password: '',
                   
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.update'), {
                    onFinish: () => this.form.reset('password'),
                })
            },
             showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        },
        }
    }
</script>
