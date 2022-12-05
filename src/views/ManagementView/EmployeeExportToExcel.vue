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
                <td scope="col">{{u.id}}</td>
                <td scope="col">{{u.firstname}}</td>
                <td scope="col">{{u.lastname}}</td>
                <td scope="col">{{u.email_address}}</td>
                <td scope="col">{{u.phonenumber}}</td>
                <td scope="col"><div v-for="uu in u.userdesignations">Employee at {{uu.name}}</div> <br /></td>
                <td scope="col" v-if="(u.status == 1)">Terminate</td>
                <td scope="col" v-if="(u.status == 0)">Active</td>
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
        axios.post("common/users").catch(res=>{
        }).then(res=>{
            this.location = res.data.result;
        });

        setTimeout(()=>{
            const table = document.getElementById("printMe");
            const wb = utils.table_to_book(table);
            writeFileXLSX(wb,"4AngelsEmployee.xlsx");
        },700)
    }
});
</script>

<style scoped>

</style>