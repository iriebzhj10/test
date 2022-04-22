<template>
    <div>
        <Head :title="title" />
        <jet-accueil-header />
            <slot>
            </slot>
        <jet-accueil-footer />
    </div>
</template>

<script>
    import JetAccueilHeader from '@/Jetstream/AccueilHeader.vue'
    import JetAccueilFooter from '@/Jetstream/AccueilFooter.vue'
    import JetAccueilPackFreePremium from '@/Jetstream/AccueilPackFreePremium.vue'
    import JetAccueilPack from '@/Jetstream/AccueilPack.vue'

    // import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
    // import JetBanner from '@/Jetstream/Banner.vue'
    // import JetDropdown from '@/Jetstream/Dropdown.vue'
    // import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
    // import JetNavLink from '@/Jetstream/NavLink.vue'
    // import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        props: {
            title: String,
        },

        components: {
            Head,
            JetAccueilHeader,
            JetAccueilFooter,
            JetAccueilPackFreePremium,
            JetAccueilPack,
            Link,
            // NavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        },
        mounted(){
               $(document).ready(function() {
                App.init();
            });

    //         window.addEventListener("load", function(){
    // var load_screen = document.getElementById("load_screen");
    // document.body.removeChild(load_screen);
// });
        },
    }
</script>
<!-- Core JS - includes jquery, bootstrap, popper, in-view and sticky-kit -->

