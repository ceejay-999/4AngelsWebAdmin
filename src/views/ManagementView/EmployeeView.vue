<template>
    <LayoutView>
        <div class="breadcrumb-wrapper breadcrumb-contacts">
        <div>
            <h1>Employee</h1>

            
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                    <a href="index.html">
                        <span class="mdi mdi-home"></span>                
                    </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Employee</li>
                </ol>
                </nav>

        </div>

        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-contact"> Add Employee
            </button>
        </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-xl-4">
                <div class="card card-default p-4">
                <a href="javascript:0" class="media text-secondary" data-toggle="modal" data-target="#modal-contact">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f9/Phoenicopterus_ruber_in_S%C3%A3o_Paulo_Zoo.jpg" class="mr-3 img-fluid rounded" alt="Avatar Image">

                    <div class="media-body">
                    <h5 class="mt-0 mb-2 text-dark">Emma Smith</h5>

                    <ul class="list-unstyled">
                        <li class="d-flex mb-1">
                        <i class="mdi mdi-map mr-1"></i>
                        <span>Nulla vel metus 15/178</span>
                        </li>

                        <li class="d-flex mb-1">
                        <i class="mdi mdi-email mr-1"></i>
                        <span>exmaple@email.com</span>
                        </li>

                        <li class="d-flex mb-1">
                        <i class="mdi mdi-phone mr-1"></i>
                        <span>(123) 888 777 632</span>
                        </li>
                    </ul>
                    </div>
                </a>
                </div>
            </div>
        </div>
    </LayoutView>
    <div class="modal fade" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header justify-content-end border-bottom-0">
                    <button type="button" class="btn-edit-icon" data-dismiss="modal" aria-label="Close">
                    <i class="mdi mdi-pencil"></i>
                    </button>

                    <div class="dropdown">
                    <button class="btn-dots-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                    </div>

                    <button type="button" class="btn-close-icon" data-dismiss="modal" aria-label="Close">
                    <i class="mdi mdi-close"></i>
                    </button>
                </div>

                <div class="modal-body pt-0">
                    <div class="row no-gutters">
                    <div class="col-md-6">
                        <div class="profile-content-left px-4">
                        <div class="card text-center widget-profile px-0 border-0">
                            <div class="card-img mx-auto rounded-circle">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/f/f9/Phoenicopterus_ruber_in_S%C3%A3o_Paulo_Zoo.jpg" class="mr-3 img-fluid rounded" alt="Avatar Image">
                            </div>

                            <div class="card-body">
                            <h4 class="py-2 text-dark">Albrecht Straub</h4>
                            <p>Albrecht.straub@gmail.com</p>
                            <a class="btn btn-primary btn-pill btn-lg my-4" href="#">Follow</a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between ">
                            <div class="text-center pb-4">
                            <h6 class="text-dark pb-2">1503</h6>
                            <p>Friends</p>
                            </div>

                            <div class="text-center pb-4">
                            <h6 class="text-dark pb-2">2905</h6>
                            <p>Followers</p>
                            </div>

                            <div class="text-center pb-4">
                            <h6 class="text-dark pb-2">1200</h6>
                            <p>Following</p>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="contact-info px-4">
                        <h4 class="text-dark mb-1">Contact Details</h4>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Email address</p>
                        <p>Albrecht.straub@gmail.com</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Phone Number</p>
                        <p>+99 9539 2641 31</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Birthday</p>
                        <p>Nov 15, 1990</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Event</p>
                        <p>Lorem, ipsum dolor</p>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
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
@import '../../assets/scss/_todo.scss';
.img-fluid{
    width: 100px;
    height: 100px !important;
}
</style>