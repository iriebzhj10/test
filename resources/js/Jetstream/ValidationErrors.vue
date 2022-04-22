<template>
    <div v-if="hasErrors">
        <!-- <div class="font-medium text-red-600">Whoops! Something went wrong.</div> -->

       <div class="alert alert-danger alert-dismissible fade show" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               <span class="sr-only">Close</span>
           </button>
            <ul class="text-center">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
       </div>
    </div>
</template>

<script>
    export default {
        computed: {
            errors() {
                return this.$page.props.errors
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            },
        }
    }
</script>
