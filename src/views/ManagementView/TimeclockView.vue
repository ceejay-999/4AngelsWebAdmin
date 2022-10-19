<template>
    <LayoutView>
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Team Activity</h2>
                    </div>

                    <div class="card-body p-0" data-simplebar style="height: 302px;">
                        <div class="media media-border-bottom py-3 align-items-center justify-content-between border-bottom px-5">
                            <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-primary text-white">
                                <i class="mdi mdi-cart-outline font-size-20"></i>
                            </div>
                            <div class="media-body pr-3">
                                <a class="mt-0 mb-1 font-size-15 text-dark" href="#">Emma Smith</a>
                                <p>Lorem ipsum dolor sit amet</p>
                            </div>

                            <span class=" font-size-12 d-inline-block"><i class="mdi mdi-clock-outline"></i> 1 min ago</span>
                        </div>

                        <div class="media media-border-bottom py-3 align-items-center justify-content-between border-bottom px-5">
                            <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-success text-white">
                                <i class="mdi mdi-email-outline font-size-20"></i>
                            </div>
                            <div class="media-body pr-3">
                                <a class="mt-0 mb-1 font-size-15 text-dark" href="#">Sophia Amanda</a>
                                <p>Donec sit amet justo dignissim</p>
                            </div>
                            <span class=" font-size-12 d-inline-block"><i class="mdi mdi-clock-outline"></i> 5 min ago</span>
                        </div>

                        <div class="media media-border-bottom py-3 align-items-center justify-content-between border-bottom px-5">
                            <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-warning text-white">
                                <i class="mdi mdi-stack-exchange font-size-20"></i>
                            </div>
                            <div class="media-body pr-3">
                                <a class="mt-0 mb-1 font-size-15 text-dark" href="#">Emily Disuja</a>
                                <p>At efficitur turpis hendrerit id</p>
                            </div>
                            <span class=" font-size-12 d-inline-block"><i class="mdi mdi-clock-outline"></i> 1 day ago</span>
                        </div>

                        <div class="media media-border-bottom py-3 align-items-center justify-content-between border-bottom px-5">
                            <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-primary text-white">
                                <i class="mdi mdi-cart-outline font-size-20"></i>
                            </div>
                            <div class="media-body pr-3">
                                <a class="mt-0 mb-1 font-size-15 text-dark" href="#">William Camble</a>
                                <p>Lorem ipsum dolor sit amet</p>
                            </div>
                            <span class=" font-size-12 d-inline-block"><i class="mdi mdi-clock-outline"></i> 10 AM</span>
                        </div>

                        <div class="media media-border-bottom py-3 align-items-center justify-content-between border-bottom px-5">
                            <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-info text-white">
                                <i class="mdi mdi-calendar-blank font-size-20"></i>
                            </div>
                            <div class="media-body pr-3">
                                <a class="mt-0 mb-1 font-size-15 text-dark" href="">Comapny Meetup</a>
                                <p >Donec sit amet justo dignissim</p>
                            </div>
                            <span class=" font-size-12 d-inline-block"><i class="mdi mdi-clock-outline"></i> 10 AM</span>
                        </div>

                        <div class="media media-border-bottom py-3 align-items-center justify-content-between border-bottom px-5">
                            <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-warning text-white">
                                <i class="mdi mdi-stack-exchange font-size-20"></i>
                            </div>
                            <div class="media-body pr-3">
                                <a class="mt-0 mb-1 font-size-15 text-dark" href="#">Support Ticket</a>
                                <p >At efficitur turpis hendrerit id</p>
                            </div>
                            <span class=" font-size-12 d-inline-block"><i class="mdi mdi-clock-outline"></i> 10 AM</span>
                        </div>

                        <div class="media media-border-bottom py-3 align-items-center justify-content-between px-5">
                            <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-success text-white">
                                <i class="mdi mdi-email-outline font-size-20"></i>
                            </div>
                            <div class="media-body pr-3">
                                <a class="mt-0 mb-1 font-size-15 text-dark" href="#">New Enquiry</a>
                                <p >Phileine has placed an new order</p>
                            </div>
                            <span class=" font-size-12 d-inline-block"><i class="mdi mdi-clock-outline"></i> 9 AM</span>
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