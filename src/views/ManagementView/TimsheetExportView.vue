<template>
    <table class="table table-hover" id="DataTable_Element">
        <thead>
            <tr>
                <th class="font-weight-bold">Employee Name</th>
                <th class="font-weight-bold">Role</th>
                <th class="font-weight-bold">Wage</th>
                <th class="font-weight-bold">Time Card</th>
                <th class="font-weight-bold">Total Hours</th>
                <th class="font-weight-bold">Total Paid</th>
                <th class="font-weight-bold">Action</th>
            </tr>
        </thead>
        
        <tbody v-for="timeshet in timesheets">
            <tr>
                <td class="font-weight-bold text-left">{{ new Date(timeshet.timesheet_date).toLocaleString('en-US',{
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
            })  }}</td>
                <td></td>
                <td></td>
                <td>{{ timeshet.timesheet_time_card }} Total Time Cards</td>
                <td class="font-weight-bold text-left"></td>
                <td class="font-weight-bold text-left"></td>
                <td></td>
            </tr>
            <tr v-for="sched in timeshet.timesheetdetails">
                <td><div>{{ sched.user_firstname+" "+ sched.user_lastname }}</div></td>
                <td><div>{{ sched.role_name }}</div></td>
                <td><div>$ {{ sched.schedule_assign_wage }}</div></td>
                <td><div v-if="sched.clock_event_isclockin == 1 && sched.clock_event_isclockout == 1 ">{{ new Date(sched.clock_event_intime).toLocaleTimeString() +" - "+ new Date(sched.clock_event_outtime).toLocaleTimeString() }}</div><div class="text-danger" v-else>No Clockin / No Clockout</div></td>
                <td><div>{{ sched.timesheet_detail_paid_hours }}</div></td>
                <td><div>${{ sched.timesheet_detail_total_est_wage }}</div></td>
                <td><a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.assignschedules_id)">Edit Clockin / Clockout</a>
                </div></td>
            </tr>
        </tbody>
    </table>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import { axios , validateForm,lStore } from '@/functions.js';
import {utils,writeFileXLSX} from 'xlsx';
import { elementLoad } from "../../functions";


export default ({
    name: "App",
    components: {
    LayoutView
    },
    data(){
        return{
            branchselected: lStore.get('selected_facility'),
            timesheets: [],
            pastschedules: [],
            loaded: "",
        }
    },
    computed: {
        variable() {
            return JSON.parse(this.$route.params.variable)
        }
    },
    mounted(){
        this.loadTable();
        let rep = setInterval(() => {
            if(this.loaded == "loaded");
            {
                clearInterval(rep);
                this.genXLSXTable();
            }
        }, 3000);
    },
    methods:{
        genXLSXTable(){
            if(this.loaded != null)
            {
                const table = document.getElementById("DataTable_Element");
                const wb = utils.table_to_book(table,{raw:true});

                writeFileXLSX(wb,`4AngelsTimesheets-${new Date().getTime()}.xlsx`);
            }
        },
        async loadTable(){
            this.timesheets = this.variable;
            this.loaded = true;
        }
    }
})
</script>
<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/sleek.min.css';

.card{
    overflow: auto;
}
.table th{
    border-bottom: none !important;
}
.card-default{
    padding: 0  !important;
}
.card-default .card-header, .card-table-border-none .card-header,.card-default .card-body, .card-table-border-none .card-body
{
    padding-left: 15px;
    padding-top: 0px;
    padding-bottom: 0px;
    padding-right: 0px;
}
.empcard{
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
.row .align-items-start
{
    width: 100%;
    padding:20px;
}
</style>