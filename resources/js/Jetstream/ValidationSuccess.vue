<template>
        <!-- <div class="font-medium text-red-600">Whoops! Something went wrong.</div> -->
       <div v-if="$page.props.flash.message" class="alert alert-success alert-dismissible fade show" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               <span class="sr-only">Close</span>
           </button>
             {{ message}}
       </div>
   
</template>

<script>
    export default {
        computed: {
            message() {
                return this.$page.props.flash.message 
            },
        }
    }
</script>

