<template>
    <LayoutView>
        <div class="breadcrumb-wrapper" v-if="branchselected != null">
            <h1 class="text-dark">Facility Name: {{branchselected}}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                    <RouterLink to="/dashboard">
                        <span class="mdi mdi-home"></span>                
                    </RouterLink>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Request</li>
                </ol>
                </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between card-design head">
                        <h2>Request</h2>
                    </div>
                    <div class="card-body">
                        <!-- <div class="responsive-data-table">
                            <table id="hoverable-data-table" class="table table-hover nowrap dataTable no-footer display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                            </table>
                        </div> -->
                    </div>
                    <div class="mt-3"></div>
                </div>
            </div>
        </div>
    </LayoutView>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import { axios , validateForm,lStore } from '@/functions.js';

export default ({
    name: "App",
    components: {
        LayoutView
    },
    data(){
        return{
            branchselected: lStore.get('selected_facility'),
        }
    },
})
</script>
<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/scss/_type.scss';
@import '../../assets/scss/_reboot.scss';
@import '../../assets/sleek.min.css';
</style>