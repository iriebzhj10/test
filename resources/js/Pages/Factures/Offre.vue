<template>
 <Head title="offre" />
 
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-account-invoice-two">
                            <div class="widget-content">
                                <div class="account-box">
                                    <div class="info">
                                        <div class="inv-title">
                                            <h2 class="text-center" style="color:white;">Offre gratuite</h2>
                                        </div>
                                        <div class="inv-balance-info">

                                            <p class="line inv-balance" style="text-decoration:line-through;">FCFA 41,000</p>
                                            
                                            <span class="inv-stats balance-credited">00,000 FCFA</span>
                                            
                                        </div>
                                    </div>
                                    <div class="acc-action">
                                       <Link href="" class="btn btn-primary">Essayer</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-account-invoice-two">
                            <div class="widget-content">
                                <div class="account-box">
                                    <div class="info">
                                        <div class="inv-title">
                                            <h2 class="text-center" style="color:white;">Offre Premium</h2>
                                        </div>
                                        <div class="inv-balance-info">
                                        </div>
                                    </div>
                                    <div class="acc-action">
                                       <Link href="" class="btn btn-primary">Voir les modules</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
</template>


<script>
//  import JetSideBar from '@/Jetstream/SideBar.vue'
  import { Head, Link } from '@inertiajs/inertia-vue3';


export default {
    props:{

    },

    components:{
    Link
    }
}
</script>
