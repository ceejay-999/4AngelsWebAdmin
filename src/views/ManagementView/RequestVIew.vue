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
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between card-design head">
                        <h2>Timesheets</h2>
                    </div>
                    <div class="card-body">
                        <div class="responsive-data-table">
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
                        </div>
                    </div>
                    <div class="mt-3"></div>
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