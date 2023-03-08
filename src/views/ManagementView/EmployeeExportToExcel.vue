<template>
    <div class="table-responsive-xl">
        <table class="table" id="printMe">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Firstname</th>
                <th scope="col">Lastname</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Locations</th>
                <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="u in location">
                <td scope="col">{{u.user_id}}</td>
                <td scope="col">{{u.user_firstname}}</td>
                <td scope="col">{{u.user_lastname}}</td>
                <td scope="col">{{u.user_email}}</td>
                <td scope="col">{{u.user_phone}}</td>
                <td scope="col"><div v-for="uu in u.facility">Employee at {{uu.facility_name}}<br /></div> </td>
                <td scope="col" v-if="(u.user_status == 0)">Terminate</td>
                <td scope="col" v-if="(u.user_status == 1)">Active</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { axios } from '@/functions';
import { read, utils, writeFile, writeFileXLSX } from 'xlsx'; 

export default ({
    name: "App",
    data(){
        return{
            location:[],
        }
    },
    mounted(){
        axios.post("usercontroller/printEmployee").catch(res=>{
        }).then(res=>{
            this.location = res.data.result;

            setTimeout(()=>{
                const table = document.getElementById("printMe");
                const wb = utils.table_to_book(table);
                writeFileXLSX(wb,"4AngelsEmployee.xlsx");
            },700)
        });
    }
});
</script>

<style scoped>

</style>