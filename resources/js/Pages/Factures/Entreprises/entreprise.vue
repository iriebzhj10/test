<template>
    <head title="Entreprise" />

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
                                <h1 style="font-size: 30px;" class="mb-4 mt-2 montserrat text-center text-indigo">Créer votre organisation</h1>
                                <!-- <p class="signup-link">Vous avez déjà un compte?  <Link :href="route('login')">Connexion</Link></p> -->
                                <form @submit.prevent="submit" class="text-left">
                                    <div class="form">
                                        <div class="row">
                                            <div id="libelle-field" class="form-group col">
                                                <label for="libelle">Nom<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="libelle" v-model="form.libelle" placeholder="Nom de l'organisation" />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div id="domaine-field" class="form-group col">
                                                <label for="domaine_id">Domaine<span class="text-danger">*</span></label>
                                                <select class="custom-select custom-select-sm" id="domaine_id" v-model="form.domaine_id">
                                                    <option v-for="domaine in domaines" :key="domaine.id">{{ domaine.libelle }}</option>
                                                </select>
                                            </div>
                                            <div id="taille-field" class="form-group col">
                                                <label for="taille">Taille(Personnel)<span class="text-danger">*</span></label>
                                                <select class="custom-select custom-select-sm" id="taille_id" v-model="form.taille_id">
                                                   
                                                    <option v-for="taille in tailles" :key="taille.id">{{ taille.libelle }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div id="site_web-field" class="form-group col">
                                                <input type="text" class="form-control" id="site_web" v-model="form.site_web" placeholder="Site web" />
                                            </div>
                                            <div id="email-field" class="form-group col">
                                                <input type="email" class="form-control" id="email" v-model="form.email" placeholder="Email" />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div id="contact-field" class="form-group col">
                                                <input type="text" class="form-control" id="contact" v-model="form.contact" placeholder="Contact" />
                                            </div>

                                            <div id="fixe-field" class="form-group col">
                                                <input type="text" class="form-control" id="fixe" v-model="form.fixe" placeholder="Téléphone fixe" />
                                            </div>
                                        </div>

                                        <!-- <div>
                                            <div id="adresse-field"  class="form-group">
                                                <input type="text" class="form-control" id="adresse" v-model="form.adresse" placeholder="Adresse">
                                            </div>
                                        </div> -->

                                        <div class="row">
                                            <div id="pays-field" class="form-group col-12">
                                                <label for="pays" class="text-center">Pays<span class="text-danger">*</span></label>
                                                <select class="custom-select custom-select-sm" id="pays_id" v-model="form.pays">
                                                    <option value="">Choisir le pays</option>
                                                    <option value="United States">United States</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="New-Zealand">New Zealand</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="American-Samoa">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Antigua Barbuda">Antigua &amp; Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Aruba">Aruba</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bermuda">Bermuda</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia">Bolivia</option>
                                                    <option value="Bosnia">Bosnia &amp; Herzegovina</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="British">British Virgin Islands</option>
                                                    <option value="Brunei">Brunei</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Cape">Cape Verde</option>
                                                    <option value="Cayman">Cayman Islands</option>
                                                    <option value="Central-African">Central African Republic</option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Costa-Rica">Costa Rica</option>
                                                    <option value="Croatia">Croatia</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czechia">Czechia</option>
                                                    <option value="Côte">Côte d’Ivoire</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican">Dominican Republic</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El-Salvador">El Salvador</option>
                                                    <option value="Equatorial-Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guernsey">Guernsey</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hong-Kong">Hong Kong SAR China</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Iran">Iran</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Laos">Laos</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon">Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libya">Libya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Macedonia">Macedonia</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Moldova">Moldova</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montenegro">Montenegro</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar (Burma)</option>
                                                    <option value="Namibia">Namibia</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="North-Korea">North Korea</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau">Palau</option>
                                                    <option value="Palestinian">Palestinian Territories</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Puerto">Puerto Rico</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russia">Russia</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="Réunion">Réunion</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="San-Marino">San Marino</option>
                                                    <option value="Saudi-Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Serbia">Serbia</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra-Leone">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Slovakia">Slovakia</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon-Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South-Africa">South Africa</option>
                                                    <option value="South-Korea">South Korea</option>
                                                    <option value="Spain">Spain</option>
                                                    <option value="Sri-Lanka">Sri Lanka</option>
                                                    <option value="Sudan">Sudan</option>
                                                    <option value="Suriname">Suriname</option>
                                                    <option value="Swaziland">Swaziland</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Syria">Syria</option>
                                                    <option value="Sao-Tome-and-Principe">São Tomé &amp; Príncipe</option>
                                                    <option value="Tajikistan">Tajikistan</option>
                                                    <option value="Tanzania">Tanzania</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Timor-Leste">Timor-Leste</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tonga">Tonga</option>
                                                    <option value="Trinidad-and-Tobago">Trinidad &amp; Tobago</option>
                                                    <option value="Tunisia">Tunisia</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                    <option value="Uganda">Uganda</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="UAE">United Arab Emirates</option>
                                                    <option value="Uruguay">Uruguay</option>
                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                    <option value="Vanuatu">Vanuatu</option>
                                                    <option value="Venezuela">Venezuela</option>
                                                    <option value="Vietnam">Vietnam</option>
                                                    <option value="Yemen">Yemen</option>
                                                    <option value="Zambia">Zambia</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div id="ville-field" class="form-group col">
                                                <label for="ville" class="text-center">Ville<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="ville" v-model="form.ville" placeholder="" />
                                            </div>
                                            <div id="adresse-field" class="form-group col">
                                                <label for="adresse" class="text-center">Adresse<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="adresse" v-model="form.adresse" placeholder="" />
                                            </div>
                                        </div>

                                        <div class="row"></div>

                                        <div class="row">
                                            <div class="col-12 custom-file-container" data-upload-id="myFirstImage">
                                                <label>Logo de votre organisation <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                                <label class="custom-file-container__custom-file">
                                                    <input type="file" class="custom-file-container__custom-file__custom-file-input" @change="recup_file" accept="image/*" id="image" />
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                                                </label>
                                                <div class="custom-file-container__image-preview"></div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <jet-button :class="{ 'opacity-25,text-center': form.processing } " :disabled="form.processing">
                                                Valider
                                            </jet-button>
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
                form: {
                    libelle: "",
                    domaine_id: "",
                    email: "",
                    taille_id: "",
                    contact: "",
                    site_web: "",
                    fixe: "",
                    adresse: "",
                    pays: "",
                    ville: "",
                    image: "",
                },
            };
        },
        mounted() {
            //First upload
            var firstUpload = new FileUploadWithPreview("myFirstImage");
            $(".tagging").select2({
                tags: true,
            });
        },

        methods: {
            submit() {
                let data = new FormData();
                data.append("image", this.form.image);
                data.append("libelle", this.form.libelle);
                data.append("domaine_id", this.form.domaine_id);
                data.append("email", this.form.email);
                data.append("taille_id", this.form.taille_id);
                data.append("contact", this.form.contact);
                data.append("site_web", this.form.site_web);
                data.append("fixe", this.form.fixe);
                data.append("pays", this.form.pays);
                data.append("ville", this.form.ville);
                data.append("adresse", this.form.adresse);
                this.$inertia.post(this.route("entreprise.store"), data, {
                    onSuccess: () => {
                        Toast.fire({
                            icon: "success",
                            title: "Entreprise crée avec success",
                        });
                        console.log(this.form);
                        this.$inertia.get("/pack");
                        this.$forceUpdate();
                    },
                });
            },
            recup_file(e) {
                this.form.image = e.target.files[0];
            },

            // togglePassword:function(){
            //     this.password.type="text";
            // }
        },
        props: ["domaines", "tailles"],
    };
</script>
