<template>
    <LayoutView>
        <div class="breadcrumb-wrapper">
            <h1>Role</h1>

            
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                    <a href="index.html">
                        <span class="mdi mdi-home"></span>                
                    </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Role</li>
                </ol>
                </nav>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between card-design head">
                        <h2>Role Table</h2>

                        <a href="https://datatables.net/examples/styling/display.html" target="_blank" class="btn btn-outline-primary btn-sm text-uppercase link">
                            <span class="mdi mdi-briefcase-plus"></span>&nbsp; Add Role
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="basic-data-table">
                            <table id="hoverable-data-table" class="table table-hover nowrap dataTable no-footer" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutView>
</template>
<script>
import LayoutView from '../SharedLayoutView/LayoutView.vue';
export default ({
    name: "App",
    components: {
    LayoutView
    },
    mounted() {
        $(document).ready(function(){
            $('#hoverable-data-table').dataTable({
              aLengthMenu: [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
              ajax : {
                url: 'https://www.4angelshc.com/mobile/roles?_batch=true',
                dataSrc: 'result'
              },
              columns : [
                { data : "id" },
                { data : "name" },
                { data : "description"},
                { data : "created_at"},
                { data : "id",
                    render: function(data){
                        return '<span class="mdi mdi-square-edit-outline"></span> <span class="mdi mdi-eye"></span> <span class="mdi mdi-trash-can red"></span>'
                    }
                }
              ],
          });
        });
    }
})
</script>
<style>
@import '../../assets/scss/_card.scss';
.red{
    color: #aa0927;
}
.head{
    background-color: #ffff !important;

}
.link{
    display: flex !important;
    align-items: center !important;
}
</style>