<template>
    <head title="Mon compte" />

    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <div class="col-md-12">
            <div class="form-container">
                <div class="form-form">
                    <div class="form-form-wrap">
                        <div class="form-container">
                            <div class="form-content">
                                <jet-validation-errors class="text-center mb-4" />
                                <h1 class="spartan text-indigo">
                                    Créer <br />
                                    Votre compte
                                </h1>
                                <p class="signup-link">Vous avez déjà un compte? <Link :href="route('login')">Connectez-vous</Link> </p>
                                <form @submit.prevent="submit" class="text-left">
                                    <div class="form">
                                        <div id="nom-field" class="form-group input row">
                                            <div class="col-2 pt-2">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-user"
                                                >
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            </div>
                                            <div class="col-10">
                                                <input id="nom" type="text" class="form-control" placeholder="Nom" v-model="form.nom" />
                                            </div>
                                        </div>

                                        <div id="prenoms-field" class="form-group input row">
                                            <div class="col-2 pt-2">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-user"
                                                >
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            </div>
                                            <div class="col-10">
                                                <input id="prenoms" type="text" class="form-control" placeholder="prenoms" v-model="form.prenoms" />
                                            </div>
                                        </div>

                                        <div id="email-field" class="form-group input row">
                                            <div class="col-2 pt-2">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-at-sign"
                                                >
                                                    <circle cx="12" cy="12" r="4"></circle>
                                                    <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                                                </svg>
                                            </div>
                                            <div class="col-10">
                                                <jet-input id="email" type="email" class="mt-1 block form-control" placeholder="email" v-model="form.email" />
                                            </div>
                                        </div>

                                        <div id="contact-field" class="row form-group input">
                                            <div class="col-2 pt-2">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-phone"
                                                >
                                                    <path
                                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                                                    ></path>
                                                </svg>
                                            </div>
                                            <div class="col-10">
                                                <jet-input id="contact" type="text" class="mt-1 block form-control" placeholder="contact" v-model="form.contact" />
                                            </div>
                                        </div>

                                        <div id="mot de passe-field" class="form-group row input mb-2">
                                            <div class="col-2 pt-2">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-lock"
                                                >
                                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                </svg>
                                            </div>
                                            <div class="col-10">
                                                <jet-input id="password" type="password" class="mt-1 block form-control" v-model="form.password" required placeholder="Mot de passe" />
                                            </div>
                                        </div>

                                        <div class="mt-2 justify-content-between">
                                            <div class="mt-3 field-wrapper toggle-pass text-center">
                                                <p class="d-inline-block">Voir le mot de passe</p>
                                                <label class="switch s-primary">
                                                    <input type="checkbox" @click="showPassword" class="d-none" />

                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-2">
                                                <input type="hidden" name="" id="" />
                                            </div>
                                            <div class="col-10 m-auto">
                                                <jet-button class="text-center mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                    Valider
                                                </jet-button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- <p class="terms-conditions">© 2020 All Rights Reserved. <a href="index.html">CORK</a> is a product of Designreset. <a href="javascript:void(0);">Cookie Preferences</a>, <a href="javascript:void(0);">Privacy</a>, and <a href="javascript:void(0);">Terms</a>.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue";
    import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
    import JetButton from "@/Jetstream/Button.vue";
    import Register from "@/Jetstream/Register.vue";
    import JetInput from "@/Jetstream/Input.vue";
    import JetCheckbox from "@/Jetstream/Checkbox.vue";
    import JetLabel from "@/Jetstream/Label.vue";
    import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
    import { Head, Link } from "@inertiajs/inertia-vue3";
    import Entreprise from "@/Pages/Auth/Entreprise.vue";

    export default {
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            Register,
            Entreprise,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },

        data() {
            return {
                form: this.$inertia.form({
                    nom: "",
                    prenoms: "",
                    email: "",
                    password: "",
                    contact: "",
                    terms: false,
                }),
            };
        },

        methods: {
            submit() {
                this.form.post(this.route("register"), {
                    onSuccess: () => {
                        this.form.reset("password", "password_confirmation");
                        Toast.fire({
                            icon: "success",
                            title: "Signed in successfully",
                        });
                        this.$inertia.get("/pack");
                    },
                });
            },

            showPassword() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            },
        },
    };
</script>
