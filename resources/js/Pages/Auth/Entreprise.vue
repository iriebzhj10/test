<template>
    <div>
    
            <div class="form-group mb-4">
                <input type="text" class="form-control" id="libelle" placeholder="Nom entreprise" v-model="form.libelle">
            </div>
            <div class="form-group mb-4">
                <select  id="domaine_id" class="form-control" v-model="domaine_id">
                    <option value="">Domaine</option>
                    <option value="1">Informatique</option>
                    <option value="2">Agriculture</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <select  id="type_entreprise_id" class="form-control" v-model="type_entreprise_id">
                    <option selected >Type organisme</option>
                    <option value="1">Entreprise</option>
                    <option value="2">ONG</option>
                </select>
            </div>
           
            <!-- <button type="submit" class="btn btn-primary mt-4">Submit</button> -->
                                    
    
    </div>
</template>

<script>
export default {
    
            data() {
            return {
                form: this.$inertia.form({
                    libelle: '',
                    domaine_id: '',
                  type_entreprise_id: '',
                    
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'))
            },
        }
}
</script>