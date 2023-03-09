<template>
    <LayoutView>
         <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body">
                        <SchedulerParent></SchedulerParent>
                    </div>
                </div>
            </div>
         </div>
    </LayoutView>
</template>
<script>
import { lStore } from "../../functions";
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import SchedulerParent from '../../components/SchedulerComps/SchedulerParent.vue';

export default ({
    name: "App",
    components: {
    LayoutView,
    SchedulerParent
    },
    data(){
        return{
            facilitychoosen: lStore.get('selected_facilityId'),
        }
    }
})
</script>
<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/scss/_type.scss';
@import '../../assets/scss/_reboot.scss';
@import '../../assets/sleek.min.css';
</style>