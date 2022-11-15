<template>
    <LayoutView>
        <div class="error-wrapper rounded border bg-white px-5">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-xl-4">
                    <h1 class="text-primary bold error-title">404</h1>
                    <p class="pt-4 pb-5 error-subtitle">We are still Developing this Page. Try Other Pages</p>
                    <RouterLink to="/dashboard" class="btn btn-primary btn-pill">Back to Home</RouterLink>
                </div>
            </div>
        </div>
    </LayoutView>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"

export default ({
    name: "App",
    components: {
        LayoutView
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