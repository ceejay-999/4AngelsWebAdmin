<template>
    <LayoutView>
        <div class="toast" >

        </div>
        <div class="breadcrumb-wrapper breadcrumb-contacts">
        <div>
            <h1>Assigned Employees</h1>    
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-0">
                <li class="breadcrumb-item">
                    <RouterLink to="/dashboard">
                    <span class="mdi mdi-home"></span>                
                    </RouterLink>
                </li>
                <li class="breadcrumb-item" aria-current="page"><RouterLink to="/branch">Facilities</RouterLink></li>
                <li class="breadcrumb-item" aria-current="page">Assigned Employees</li>
            </ol>
            </nav>
        </div>
        </div>
        <div class="card" role="">
            <div class="modal-content">
            <div class="modal-header justify-content-end border-bottom-0">
            </div>

            <div class="modal-body pt-0">
                <div class="row no-gutters">
                <div class="col-md-12">
                    <div class="profile-content-left px-4">
                        <div class="card text-center widget-profile px-0 border-0">
                            <div class="card-img mx-auto rounded-circle">
                                <img :src="branches.branch_img" class="mr-3 img-fluid rounded" alt="Avatar Image">
                            </div>

                            <div class="card-body">
                            <h4 class="py-2 text-dark">{{branches.name}}</h4>
                            <p>{{branches.location}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr />
                    <div class="contact-info px-4 contact-details">
                        <h4 class="text-dark mb-1">Employee Assigned Today Schedule</h4>
                    </div>
                    <div class="card-body">
                        <div class="responsive-data-table">
                            <table id="hoverable-data-table" class="table table-hover nowrap dataTable no-footer display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Position</th>
                                        <th>Schedule</th>
                                        <th>Clock In</th>
                                        <th>Clock Out</th>
                                        <th>Clock In Location</th>
                                        <th>Clock Out Location</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </LayoutView>
</template>
<script>

import { lStore,axios } from '../../functions';

export default({
  name: 'LoginPage',
  data() {
      return{
        branches: {},
      };
  },
  mounted() {
    axios.post("branches?id="+lStore.get('branchidemp')).catch(res=>{

    }).then(res=>{
        if(res.data.success){
            this.branches = res.data.result;

        }

    });
    document.querySelector(".toast").id = "";
            $('#hoverable-data-table').dataTable({
              aLengthMenu: [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
              rowReorder: {
                selector: 'td:nth-child(2)'
              },
              responsive: true,
              ajax : {
                url: 'https://www.4angelshc.com/mobile/timerecord?mobile_schedule:branch_id=20&_joins=mobile_schedule&_on=mobile_timerecord.schedule_id=mobile_schedule.id&_GTE_time_in=2022-11-16&_LSE_time_in=2022-11-17&_batch=true',
                dataSrc: 'result'
              },
              columns : [
                { data : "id" },
                { data : "position" },
                { data : "created_at" },
                { data : "id",
                    render: function(data){
                        return '<a class="actionb" data-toggle="modal" data-target="#exampleEditModalForm" target="_blank"><span id="editrow" data-value='+data+' class="mdi mdi-square-edit-outline"></span></a> <a class="actionb" data-toggle="modal" data-target="#exampleModalTooltip" target="_blank"><span id="viewrow" data-value='+data+' class="mdi mdi-eye"></span></a> <a class="actionb" data-toggle="modal" data-target="#exampleModal" target="_blank"><span id="deleterow" data-value='+data+' class="mdi mdi-trash-can red"></span></a>'
                    }
                }
              ],
          });
  }
});
</script>
<style scoped>
@import 'chosen-js/chosen.css';
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/scss/_type.scss';
@import '../../assets/scss/_reboot.scss';
@import '../../assets/sleek.min.css';
.img-fluid{
    width: 100px;
    height: 100px !important;
}
.textcenter{
    display: none;
    margin: 0 auto;
    font-size: 20px;
}
.card {
    overflow: hidden;
}
.contact-details{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
}
</style>