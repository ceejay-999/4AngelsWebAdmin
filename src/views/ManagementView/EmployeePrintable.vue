<template>
    <div class="table-responsive-xl" id="printMe">
        <table class="table">
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
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js';
        document.body.appendChild(script);
        setTimeout(()=>{
            let opt = {
                margin: [10,10,10,10],
                filename: `4AngelsEmployee.pdf`,
                image: { type: 'jpeg', quality: 2 },
                html2canvas: {
                    dpi: 300,
                    scale:2,
                    letterRendering: true,
                    useCORS: true
                },
                jsPDF: { unit: 'mm', orientation: 'landscape',format:'letter'},
                pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
            };
            try{
                html2pdf(document.querySelector('#printMe'),opt).save()
            }catch(e){
                console.log('printed');
            }
        },1000);
    }
});
</script>

<style scoped>

</style>