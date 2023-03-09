<template>
<div class="scheduler-form-modal" :class="{closed:modalClose}">
    <div class="scheduler-form-parent">
        <div class="scheduler-form-header">
            <h4>{{(queSchedule.id == '') ? 'Add' : 'Edit'}} Schedule</h4>
            <a href="javascript:;" @click.prevent="modalClose=true;$emit('close',modalClose)">&#10006;</a>
        </div>
        <div class="scheduler-form-body">
            <div class="scheduler-form-inputs">
                <label>Start Date</label>
                <CustomFieldVue 
                    type="date"
                    name="scheduler-form-datestart"
                    :readonly="true"
                    :value="queSchedule.shift_date"
                />
                <label v-if="queSchedule.id == ''">End Date</label>
                <CustomFieldVue 
                    v-if="queSchedule.id == ''"
                    type="date"
                    name="scheduler-form-dateend"
                    :value="queSchedule.shift_date_end"
                    @on-result="e=>queSchedule.shift_date_end=e"
                />
                <label>Start Time</label>
                <CustomFieldVue 
                    type="time"
                    name="scheduler-form-timestart"
                    :value="queSchedule.shift_start"
                    @on-result="e=>queSchedule.shift_start=e"
                />
                <label>End Time</label>
                <CustomFieldVue 
                    type="time"
                    name="scheduler-form-timeend"
                    :value="queSchedule.shift_end"
                    @on-result="e=>queSchedule.shift_end=e"
                />
                <label v-if="queSchedule.id == ''">Repeat Days</label>
                <CustomFieldVue 
                    v-if="queSchedule.id == ''"
                    type="checkbox-group"
                    name="scheduler-form-repeatdays"
                    columns="1fr 1fr 1fr 1fr"
                    :values="[
                        {label:'Sun',value:0},
                        {label:'Mon',value:1},
                        {label:'Tue',value:2},
                        {label:'Wed',value:3},
                        {label:'Thu',value:4},
                        {label:'Fri',value:5},
                        {label:'Sat',value:6}
                    ]"
                    :select="queSchedule.repeatDays"
                    @on-result="e=>queSchedule.repeatDays=e"
                />
                <label>Role</label>
                <CustomFieldVue 
                    type="select"
                    name="scheduler-form-repeatdays"
                    columns="1fr 1fr 1fr 1fr"
                    :values="[
                        {label: 'IT Support',value:0},
                        {label: 'RNA',value:1},
                        {label: 'CNA',value:2},
                        {label: 'LPA',value:3}
                    ]"
                    :value="queSchedule.designation"
                    @on-result="e=>queSchedule.designation=e"
                />
                <label>Slots</label>
                <CustomFieldVue 
                    type="integer"
                    placeholder="Maximum no. of slots"
                    name="scheduler-form-slots"
                    :value="queSchedule.slots"
                    @on-result="e=>queSchedule.slots=e"

                />
                <label>Description</label>
                <CustomFieldVue 
                    type="textarea"
                    name="scheduler-form-description"
                    placeholder="You can provide more details about the schedule here..."
                    :value="queSchedule.description"
                    @on-result="e=>queSchedule.description=e"
                />
            </div>
            <p class="errormsg" v-if="errormsg != ''" v-html="errormsg"></p>
            <div class="text-align-right">
                <button @click="setSchedule">{{(queSchedule.id == '') ? 'Add' : 'Edit'}} Schedule</button>
                <button @click="deleteSched" class="danger" v-if="queSchedule.id != ''">Delete Schedule</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {validateForm} from './scheduler.utils'
import CustomFieldVue from './CustomField.vue';

export default{
    components:{CustomFieldVue},
    props:{modalCloseProp:Boolean,schedule:Object},
    data(){
        return{
            modalClose:true,
            errormsg:'',
            queSchedule:{
                id:'',
                shift_date: '',
                shift_date_end: '',
                shift_start:'',
                shift_end:'',
                repeatDays:[0,1,2,3,4,5,6],
                description:'',
                branch_id:0,
                designation: 1,
                slots:0
            }
        }
    },
    methods:{
        resetQueSched(){
            this.queSchedule={
                id:'',
                shift_date: '',
                shift_date_end: '',
                shift_start:'07:00',
                shift_end:'13:00',
                repeatDays:[0,1,2,3,4,5,6],
                description:'',
                branch_id:0,
                designation: 1,
                slots:0
            }
        },
        deleteSched(){
            if(!confirm('Confirm deletion?')) return;
            this.$emit('onDelete',this.queSchedule.id)
            this.modalClose = true;
        },
        setSchedule(){
            this.errormsg = '';
            let emptyFieldsErrorMsg = 'The following fields are required:<br>';
            let rules = {
                shift_start:'required',
                shift_end:'required',
                slots:'required',
            };
            
            if(this.queSchedule.id == ''){
                rules = {
                    shift_date_end:'required',
                    shift_start:'required',
                    shift_end:'required',
                    slots:'required',
                }
            }

            rules.callback = (v)=>{
                switch(v){
                    case 'shift_date_end':
                        emptyFieldsErrorMsg+='<strong>End Date</strong>, '
                    break;
                    case 'shift_start':
                        emptyFieldsErrorMsg+='<strong>Start Time</strong>, '
                    break;
                    case 'shift_end':
                        emptyFieldsErrorMsg+='<strong>End Time</strong>, '
                    break;
                    case 'slots':
                        emptyFieldsErrorMsg+='<strong>Slots</strong>, '
                    break;
                }
            }

            let valid = validateForm(this.queSchedule,rules);
            emptyFieldsErrorMsg = emptyFieldsErrorMsg.substring(0,emptyFieldsErrorMsg.length-2);
            

               

            if(!valid.allValid){
                this.errormsg = emptyFieldsErrorMsg;
                return;
            }

            if(this.queSchedule.slots <= 0){
                this.errormsg = '<strong>Slots</strong> field must be greater than 0';
                return;
            }

            if(this.queSchedule.id == '' && this.queSchedule.repeatDays.length == 0){
                this.errormsg = '<strong>Repeat Days</strong> field should have at least one check';
                return;
            }

            if(this.queSchedule.id == '' && new Date(this.queSchedule.shift_date_end).getTime() < new Date(this.queSchedule.shift_date).getTime()){
                this.errormsg = '<strong>End Date</strong> must be set later than the Start Date';
                return;
            }

            

            if(this.queSchedule.id == '')
                this.$emit('onCreate',JSON.parse(JSON.stringify(this.queSchedule)));
            else
                this.$emit('onUpdate',JSON.parse(JSON.stringify(this.queSchedule)));
        }
    },
    watch:{
        modalCloseProp(){
            this.modalClose = this.modalCloseProp;
        },
        schedule:{
            handler(){
                this.errormsg = '';
                for(let sd in this.schedule){
                    this.queSchedule[sd] = this.schedule[sd];
                }
                this.queSchedule.shift_date_end = this.queSchedule.shift_date;
            },
            deep:true
        }
    }
}
</script>

<style scoped>
.scheduler-form-modal{position:fixed;top:0;left:0;width:100vw;height: 100vh;background: rgba(0,0,0,0.5);z-index: 9999;opacity: 1;transition: 0.3s ease-out;}
.scheduler-form-modal.closed{z-index: -100;opacity: 0;}
.scheduler-form-modal.closed .scheduler-form-parent{top:-100%}
.scheduler-form-parent{background: #fff;max-width: 500px;width: 90%;position: absolute;top:50%;left:50%;transform:translateX(-50%) translateY(-50%);border-radius: 5px;transition: 0.5s ease-out;}

.scheduler-form-header{padding:20px;background: #1b98e3;color:#fff;border-radius: 5px 5px 0 0;position: relative;}
.scheduler-form-header a{all:unset;position: absolute;right:20px;top:50%;transform:translateY(-50%);transition: 0.1s;height: 30px;width: 30px;line-height:30px;text-align: center;}
.scheduler-form-header a:hover{scale: 1.1;}
.scheduler-form-header a:active{scale: 0.9;}
.scheduler-form-body{padding: 20px}
.scheduler-form-inputs{display: grid;grid-template-columns: 1fr 3fr;gap: 5px;margin-bottom: 20px;}
.scheduler-form-inputs label{margin-top:5px;}

button{
    all: unset;
    background: #3d843d;
    color: #fff;
    padding: 7px;
    border-radius: 5px;
    margin: 0 2px;
    font-size: 14px;
    transition: 0.2s;
}

button:hover{scale:1.05}
button:active{scale:0.95}

button.danger{
    background: #a2493e;
}

.errormsg{
    margin: 10px 0 10px;
    border: 1px solid #900;
    padding: 5px;
    background: #ffd3d3;
    color: #593434;
    font-size: 15px;
    text-align: center;
    border-radius: 5px;
}

.text-align-right{text-align: right;}

</style>
