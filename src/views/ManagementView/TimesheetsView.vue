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
                    <li class="breadcrumb-item" aria-current="page">Timesheets</li>
                </ol>
                </nav>
        </div>
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Employee Timesheets</h2>
            </div>
            <div class="card-body">
                
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
    mounted(){

    }
})
</script>
<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/sleek.min.css';
</style>