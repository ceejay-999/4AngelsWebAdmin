<template>
    <LayoutView>
        <AppointView :facilityId=facilitychoosen>

        </AppointView>
    </LayoutView>
</template>
<script>
import { lStore } from "../../functions";
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import AppointView from "../../views/SharedLayoutView/Scheduler.vue"

export default ({
    name: "App",
    components: {
    LayoutView
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