<template>
    <div>
        <Head :title="title" />
        <div class="min-h-screen bg-gray-100">

            <jet-header1 />

            <!-- <jet-header2 /> -->


            <!-- Page Heading -->
            <!-- <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header> -->

            <!-- Page Content -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->

         <jet-side-bar />

        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT PART  -->
         <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">
                        <slot></slot>
                    </div>
            </div>

            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © 2021 <a target="_blank" href="https://ediqia.com">Ediqia</a>, Tout droits reservés.</p>
                </div>
                <div class="footer-section f-section-2">
                    <!-- <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p> -->
                </div>
            </div>
        </div>

        <!--  END CONTENT PART  -->

    </div>

        </div>
    </div>
</template>

<script>
    import JetHeader1 from '@/Jetstream/Header1.vue'
    import JetHeader2 from '@/Jetstream/Header2.vue'
    import JetSideBar from '@/Jetstream/SideBar.vue'

    import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
    import JetBanner from '@/Jetstream/Banner.vue'
    import JetDropdown from '@/Jetstream/Dropdown.vue'
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        props: {
            title: String,
        },

        components: {
            Head,
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetSideBar,
            JetNavLink,
            JetHeader1,
             JetHeader2,
            JetResponsiveNavLink,
            Link,
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
