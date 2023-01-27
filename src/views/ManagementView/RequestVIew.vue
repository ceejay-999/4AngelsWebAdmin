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
                    <li class="breadcrumb-item" aria-current="page">Requests</li>
                </ol>
                </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between card-design head">
                        <h2>Requests</h2>
                    </div>
                    <div class="card-body">
                        <div class="requests_panel">
                            <div class="requests_panel_header">
                                <ul id="mytab" role="tablist" class="nav nav-tabs px-3 px-xl-5 nav-style-border">
                                    <li><a @click="viewMode = -1;viewRequest = null" class="nav-link active" data-toggle="tab" >All</a></li>
                                    <li><a @click="viewMode = 0;viewRequest = null" class="nav-link" data-toggle="tab" >Schedule Applications</a></li>
                                    <li><a @click="viewMode = 1;viewRequest = null" class="nav-link" data-toggle="tab" >Reschedule Requests</a></li>
                                    <li><a @click="viewMode = 2;viewRequest = null" class="nav-link" data-toggle="tab" >Reassign Requests</a></li>
                                </ul>
                            </div>
                            <div class="requests_panel_body">
                                <div id="view_request" v-if="viewRequest != null">
                                    <h4>{{requestType(viewRequest.requests_type)}}</h4>
                                    <div class="request_col2">
                                        <strong>Request ID</strong> <span>{{viewRequest.requests_id}}</span>
                                        <strong>Schedule ID</strong> <span>{{viewRequest.requests_schedulesid}}</span>
                                        <strong>Employee</strong> <span>{{viewRequest.employee_lastname}}, {{viewRequest.employee_firstname}}</span>
                                        <strong v-if="viewRequest.requests_type == 2">Reassign To</strong> <span v-if="viewRequest.requests_type == 2">{{fetchEmployee(viewRequest.requests_reassign_employeeid)}} {{viewRequest.reassign_lastname}}, {{viewRequest.reassign_firstname}}</span>
                                        <strong>Created At</strong> <span>{{dateFormatV2('%sm %d, %y (%h:%i%a)',viewRequest.requests_created_at)}}</span>
                                        <strong>Status</strong> <span>{{status(viewRequest.requests_status)}}</span>
                                    </div>

                                    <div class="request_section">
                                        <div :class="viewRequest.requests_type == 1 ? 'request_div2':''" >
                                            <div>
                                                <strong class="title">Current Schedule</strong> 
                                                <div class="request_col2">
                                                    <strong>Schedule Date</strong>
                                                    <span>{{dateFormatV2('%sm %d, %y',viewRequest.schedules_dates)}}</span>
                                                    <strong>Role</strong>
                                                    <span>{{viewRequest.role_name}}</span>
                                                    <strong>Schedule Start</strong>
                                                    <span>{{dateFormatV2('%h:%I %A',viewRequest.schedules_timestart)}}</span>
                                                    <strong>Schedule End</strong>
                                                    <span>{{dateFormatV2('%h:%I %A',viewRequest.schedules_timeend)}}</span>
                                                </div>

                                                <button class="view_request_button margin-top-20" @click="gotoSchedule(viewRequest.requests_schedulesid)">
                                                    <img draggable="false" title="Approve" class="actionIcons" src="../../assets/calendar-icon.svg">
                                                    View in Job Scheduler
                                                </button>
                                            </div>
                                            
                                            <div v-if="viewRequest.requests_type == 1">
                                                <strong class="title">Reschedule To</strong>
                                                <div class="request_col2">
                                                    <strong>Date</strong>
                                                    <span>{{dateFormatV2('%sm %d, %y',viewRequest.requests_resched_date)}}</span>
                                                    <strong>Role</strong>
                                                    <span>{{viewRequest.role_name}}</span>
                                                    <strong>Start Time</strong>
                                                    <span>{{dateFormatV2('%h:%I %A',viewRequest.requests_resched_timestart)}}</span>
                                                    <strong>End Time</strong>
                                                    <span>{{dateFormatV2('%h:%I %A',viewRequest.requests_resched_timeend)}}</span>
                                                </div>

                                                <button class="view_request_button margin-top-20" @click="gotoSchedule(viewRequest.requests_new_schedulesid)" v-if="viewRequest.requests_status == 1">
                                                    <img draggable="false" title="Approve" class="actionIcons" src="../../assets/calendar-icon.svg">
                                                    View in Job Scheduler
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="request_section">
                                        <strong class="title">Reason</strong> 
                                        <span class="full">{{viewRequest.requests_reason ?? 'No reason provided...'}}</span>
                                    </div>

                                    <div class="request_section" v-if="viewRequest.requests_status != 0">
                                        <div class="request_col2">
                                            <strong >{{viewRequest.requests_status == 1 ? 'Approved' : 'Denied'}} by</strong> 
                                            <span>ID-{{viewRequest.requests_approvedby}}</span>
                                            <strong >Date</strong> 
                                            <span>{{dateFormatV2('%sm %d, %y (%h:%i%a)',viewRequest.requests_updated_at)}}</span>
                                        </div>
                                    </div>

                                    <button v-if="viewRequest.requests_status == 0" class="view_request_button approve" @click="approveOrDeny(viewRequest.requests_id,1,viewRequest)">
                                        <img draggable="false" title="Approve" class="actionIcons" src="../../assets/approve-icon.svg">
                                        Approve
                                    </button>

                                    <button v-if="viewRequest.requests_status == 0" class="view_request_button deny" @click="approveOrDeny(viewRequest.requests_id,2,viewRequest)">
                                        <img draggable="false" title="Approve" class="actionIcons" src="../../assets/deny-icon.svg">
                                        Deny
                                    </button>

                                    
                                </div>

                                <DataTables
                                    :url="`requests?${(viewMode!=-1) ? '&requests_type='+viewMode : ''}&_joins=employee,schedules,role&_on=requests.requests_employeeid=employee.employee_id,requests.requests_schedulesid=schedules.schedules_id,role.role_id=schedules.schedules_roleid`"
                                    columns="requests_type,requests_schedulesid,employee_lastname,requests_reason,requests_status"
                                    columnNames="Type, Schedule ID, Employee, Reason, Status, Action" 
                                    columnPrefix="requests_" 
                                    v-slot="row"
                                    :formatValues="{
                                        requests_type:{
                                            replace:[
                                                ['0','Schedule Application'],
                                                ['1','Reschedule Request'],
                                                ['2','Reassign Request'],
                                            ]
                                        },
                                        employee_lastname:{
                                            render: (value,row)=>{
                                                return value+', '+row.employee_firstname;
                                            }
                                        },
                                        requests_reason:{
                                            render: (value)=>{
                                                return value ?? `<em style='color:#777'>No reason provided...</em>`;
                                            }
                                        },
                                        requests_status:{
                                            replace:[
                                                ['0','Pending'],
                                                ['1','Approved'],
                                                ['2','Denied'],
                                            ]
                                        },
                                    }"
                                >
                                    <div class="action_btns">
                                        <img draggable="false" title="View" @click="viewRequestCard(row.data)" class="actionIcons" src="../../assets/view-icon.svg">
                                        <img draggable="false" title="Approve" v-if="row.data.requests_status == 0" @click="approveOrDeny(row.data.requests_id,1,row.data)" class="actionIcons approve" src="../../assets/approve-icon.svg">
                                        <img draggable="false" title="Deny" v-if="row.data.requests_status == 0" @click="approveOrDeny(row.data.requests_id,2,row.data)" class="actionIcons deny" src="../../assets/deny-icon.svg">
                                    </div>
                                </DataTables>

                                
                            </div>
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
import DataTables from "../../views/SharedLayoutView/DataTables.vue"
import { lStore,dateFormatV2,axios } from '@/functions.js';

export default ({
    name: "App",
    components: {
        LayoutView,
        DataTables,
    },
    data(){
        return{
            branchselected: lStore.get('selected_facility'),
            viewMode:-1,
            viewRequest:null
        }
    },
    methods:{
        dateFormatV2,
        viewRequestCard(v){
            this.viewRequest = JSON.parse(JSON.stringify(v))
        },
        gotoSchedule(id){
            window.open('/adminapp/jobschedule?schedule='+id);
        },
        status(num){
            num = parseInt(num);
            switch(num){
                case 0: return 'Pending';
                case 1: return 'Approved';
                case 2: return 'Denied';
            }
        },
        requestType(num){            
            num = parseInt(num);
            switch(num){
                case 0: return 'Schedule Application';
                case 1: return 'Reschedule Request';
                case 2: return 'Reassign Requests';
            }
        },
        approveOrDeny(id,status,data){
            if(!confirm("Do you want to proceed with your action? This can't be undone!")) return;
            let response = null;

            if(status == 2){
                axios.encrypted('requests/update?id='+id,null,{
                    requests_status:status,
                    requests_approvedby: lStore.get('users_id'),
                    requests_updated_at: new Date().toLocaleString('zh-Hans-CN')
                })
                .then(()=>{
                    window.location.reload();
                })

                return;
            }

            if(data.requests_type == 0) response = this.createNewAssign(data);
            else if (data.requests_type == 1) response = this.rescheduleAssign(data);
            else if (data.requests_type == 2) response = this.reassignSchedule(data);

            response.then(res=>{
                let params = {
                    requests_status:status,
                    requests_approvedby: lStore.get('users_id'),
                    requests_updated_at: new Date().toLocaleString('zh-Hans-CN')
                };

                if(res != null && data.requests_type == 1) params.requests_new_schedulesid = res;
                axios.encrypted('requests/update?id='+id,null,params)
                .then(()=>{
                    window.location.reload();
                })

            })

            
        },
        async createNewAssign(data){
            return new Promise(resolve=>{
                axios.encrypted(`userDesignations?
                    assigndesignation_facilityid=`+data.schedules_facilityid+
                    `&assigndesignation_employeeid=`+data.employee_id)
                .then(res=>{
                    res.data = axios.decryptToJSON(res.data);
                    axios.encrypted(`Assign/create`,null,{
                        assignschedules_assigndesignationid: res.data.result.assigndesignation_id,
                        assignschedules_scheduleid: data.schedules_id,
                        assignschedules_status: 10,
                    })
                    .then(()=>{
                        resolve();
                    })
                })
            });
        },
        async rescheduleAssign(data){
            return new Promise(resolve=>{
                axios.encrypted(`userDesignations?
                    assigndesignation_facilityid=`+data.schedules_facilityid+
                    `&assigndesignation_employeeid=`+data.employee_id)
                .then(res=>{
                    res.data = axios.decryptToJSON(res.data);
                    axios.encrypted('Assign/delete?scheduleid='+data.schedules_id+'&assigndesignationid='+res.data.result.assigndesignation_id,null).then(()=>{
                        let newId = (lStore.get('users_id')).toString(32)+'-'+new Date().getTime().toString(32)+'-0';
                        axios.encrypted('Schedule/create',null,{
                            schedules_dates:data.requests_resched_date,
                            schedules_description:data.schedules_description,
                            schedules_facilityid:data.schedules_facilityid,
                            schedules_id:newId,
                            schedules_roleid:data.schedules_roleid,
                            schedules_timestart:data.requests_resched_timestart,
                            schedules_timeend:data.requests_resched_timeend,
                        }).then(()=>{
                            axios.encrypted(`Assign/create`,null,{
                                assignschedules_assigndesignationid: res.data.result.assigndesignation_id,
                                assignschedules_scheduleid: newId,
                                assignschedules_status: 10,
                            })
                            .then(()=>{
                                resolve(newId);
                            })
                        })
                    });
                });
            });
        },
        async reassignSchedule(data){
            return new Promise(resolve=>{
                axios.encrypted(`userDesignations?
                    assigndesignation_facilityid=`+data.schedules_facilityid+
                    `&assigndesignation_employeeid=`+data.employee_id+
                    `&_ORW_employeeid=`+data.requests_reassign_employeeid+
                    `&_batch=true`)
                .then(res=>{
                    res.data = axios.decryptToJSON(res.data);
                    let oldEmpAssign = res.data.result.filter(el=>el.assigndesignation_employeeid==data.employee_id)[0];
                    let newEmpAssign = res.data.result.filter(el=>el.assigndesignation_employeeid==data.requests_reassign_employeeid)[0];

                    axios.encrypted('Assign/update?scheduleid='+data.schedules_id+'&assigndesignationid='+oldEmpAssign.assigndesignation_id,null,{
                        assignschedules_assigndesignationid: newEmpAssign.assigndesignation_id
                    }).then(()=>{
                        resolve();
                    })
                    
                });
            });
        },
        fetchEmployee(id,asRawData=false){
            axios.encrypted('employee?employee_id='+id)
            .then(res=>{
                res.data = axios.decryptToJSON(res.data);

                if(asRawData) return res.data.result;

                for(let e in res.data.result){
                    let key = e.replace('employee_','reassign_');
                    this.viewRequest[key] = res.data.result[e];
                }
            })
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

.requests_panel_body{padding: 20px;}

.action_btns img{
    padding: 7px;
    background: #2095db;
    border-radius: 5px;
    width: 35px;
    height: 35px;
    border: none;
    color:#fff;
    font-weight: 600;
    font-family: 'Poppins';
    display: block;
    transition: 0.2s;
}

.action_btns img:hover{scale: 1.05;}
.action_btns img:active{scale: 0.95;filter:brightness(120%)}
.action_btns img.approve,.view_request_button.approve{background: rgb(51, 116, 70);}
.action_btns img.deny,.view_request_button.deny{background: rgb(127, 70, 43);}



.view_request_button{background: #2095db;color:#fff;padding: 7px 10px;border-radius:5px;margin: 0 5px;font-size: 14px;}
.view_request_button:first-of-type{margin-left: 0;}
.view_request_button img{width: 20px;vertical-align: middle;margin-right: 3px;margin-top: -5px;}
.view_request_button:hover{scale: 1.05;}
.view_request_button:active{scale: 0.95;filter:brightness(120%)}

.margin-top-20{margin-top: 20px;}

.action_btns{display: flex;justify-content:center;gap:5px}

#view_request{
    margin: 20px 0 40px;
    padding: 20px;
    border-radius: 5px;
    border:1px solid #e3e3e2;
}
#view_request h4{margin-bottom: 20px;}
#view_request strong{font-weight: 600;}

.request_col2{display: grid;grid-template-columns: 1fr 3fr 1fr 3fr;gap:10px}
.request_col2 .full{grid-column: span 3;}
.request_col2 span,.request_col2 strong{line-height: 100%;font-weight: inherit;}
.request_col2 span{color:#2095db;font-weight: 600;}

.request_div2{display: grid;grid-template-columns: 1fr 1fr;gap:10px}
.request_div2 .request_col2{display: grid;grid-template-columns: 1fr 1fr 1fr 1fr;gap:10px}
.request_div2 .request_col2 .full{grid-column: span 3;}
.request_div2 > div:nth-child(2) {border-left: 1px solid #dedede;padding-left: 20px;}

.request_section{padding: 15px 0 0 ;border-top:1px solid #dedede;margin-top: 20px;border-radius: 5px;}
.request_section:last-of-type{margin-bottom: 20px;}
strong.title{display: block;margin-bottom: 10px;font-weight: 600;}

@media (max-width: 1500px) {
    .request_div2 .request_col2{grid-template-columns: 4fr 5fr;}
}

@media (max-width: 1400px) {
    .request_col2{grid-template-columns: 1fr 2fr 1fr 2fr;}
}

@media (max-width: 1200px) {
    .request_col2{grid-template-columns:  5fr 9fr  5fr 9fr;}
}

@media (max-width: 1000px) {
    .request_div2{grid-template-columns: 1fr;}
    .request_div2 > div:nth-child(2){border:none;border-top:1px solid #dedede;padding-left:0;padding-top: 20px;}
    .request_col2{grid-template-columns:  4fr 5fr;}
}

@media (max-width: 600px) {
    
}
</style>