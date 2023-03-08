<template>
    <div class="filemngr_cont" @drop.prevent="dropFile" @dragover.prevent="hoverTitle='Drop files here!'" @dragleave="hoverTitle='Hover on a file...'" @dragleave.prevent>
        <div class="filemng_top_ctrl">
                <button class="bulkSelect" :class="{buttonActive: bulkSelect}" @click="bulkSelect = !bulkSelect;chosenFile=[]">Bulk Select {{bulkSelect ? 'On': 'Off'}}</button>
                <button class="delete" @click="deleteSelected">Delete</button>
                <button class="view" v-if="!bulkSelect && chosenFile.length > 0" @click="openFile" >Download</button>
                <button class="choose" @click="chooseFile" v-if="chosenFile.length > 0">Choose {{chosenFile.length}} File(s)</button>
                <button class="keepName" :class="{keepNameActive: keepName}" @click="keepName = !keepName;">{{!keepName ? 'Don\'t': ''}} Keep Name on Upload </button>
            </div>
        <div class="filemngr_vwr">
            <div class="filemngr_vwr_itm" v-for="f in files" :key="f" @click="addToChosen(f)" :class="{active:(chosenFile.includes(f))}" @mouseenter="hoverTitle = f" @mouseleave="hoverTitle = 'Hover on a file...'">
                <div class="filemngr_itm_disp" >
                    <img class="selectInd" src="../../assets/check-icon.svg" v-if="chosenFile.includes(f)">
                    <img :src="path+'/'+f" v-if="fileType(f) == 'image'">
                    <img class="fileicon" src="../../assets/file-icon.svg" v-if="fileType(f) == 'document'">
                </div>
                <p class="filemngr_itm_name">{{f}}</p>
            </div>
            <div class="filemngr_vwr_itm"  v-for="u,i in uploading" :key="i">
                <div class="filemngr_itm_disp upload" >
                    <span>{{u}}%</span>
                </div>
                <p class="filemngr_itm_name">[Uploading] {{i}}</p>
            </div>

            <div class="filemngr_vwr_itm">
                <label for="openFile">
                <div class="filemngr_itm_disp" >
                    <img class="uploadicon" src="../../assets/upload-icon.svg">
                </div>
                </label>
                <input type="file" id="openFile" hidden @change="uploadFile">
                <p class="filemngr_itm_name">Add File</p>
            </div>
        </div>
        <span class="hoverTitle">{{hoverTitle}}</span>
    </div>
</template>


<script>
import {axios,lStore} from '../../functions.js'

//--- DELETE ALL CODE BEFORE THIS ---
//import {ciapi} from '@/js/globals'
//import {axiosReq}
//import axios from 'axios'
//
const cifile = 'https://www.4angelshc.com/wangelmobile/filesystem/';

export default({
    props:["user_id"],
    data(){
        return{
            files:[],
            path:'',
            relativePath:'',
            chosenFile:[],
            uploading:{},
            bulkSelect: false,
            hoverTitle:'Hover on a file...',
            keepName: false
        }
    },
    mounted(){
        this.path = cifile+lStore.get('employeeid');
        this.relativePath = lStore.get('employeeid');
        axios.post('files/index?path='+this.relativePath).then(res=>{
            this.files = res.data.result;
        });
    },
    methods:{
        fileType(filename){
            if(typeof filename != 'string') return;
            let fileSplit = filename.toLowerCase().split('.');
            let ext = fileSplit[fileSplit.length - 1];
            let image = ['gif','png','jpg','jpeg'];
            let video = ['mp4','webm','ogv'];
            let doc = ['doc','docx','xls','xlsx','csv','pdf'];
            if(image.includes(ext)) return 'image'; 
            if(video.includes(ext)) return 'video';
            if(doc.includes(ext)) return 'document';
            return '';
        },
        addToChosen(f){
            if(this.bulkSelect) {
                if(!this.chosenFile.includes(f)) this.chosenFile.push(f);
                else this.chosenFile.splice(this.chosenFile.indexOf(f),1);
            }
            else {
                if(this.chosenFile[0] != f) this.chosenFile[0] = f;
                else this.chosenFile.splice(0,1);
            }
        },
        dropFile(e){
            if(e.dataTransfer.files[0] == null) return;
            let file = e.dataTransfer.files[0];

            axios.post('files/upload?path='+this.relativePath+'&type='+this.fileType(file.name)+'&keep_filename='+this.keepName,null,{file},{
                onUploadProgress:progressEvent =>{
                    let uploadProgress = (progressEvent.loaded / file.size) * 100;
                    this.uploading[file.name] = uploadProgress.toFixed(2);
                }
            }).then(res=>{
                console.log(res.data);
                if(res.data.success === false) alert(res.data.msg)
                delete this.uploading[file.name];
                this.files.push(res.data.file_name);
            });
        },
        uploadFile(e){
            let file = e.target.files[0];
            console.log(this.keepName);
            axios.post('files/upload?path='+this.relativePath+'&type='+this.fileType(file.name)+'&keep_filename='+this.keepName,null,{file},{
                onUploadProgress:progressEvent =>{
                    let uploadProgress = (progressEvent.loaded / file.size) * 100;
                    this.uploading[file.name] = uploadProgress.toFixed(2);
                }
            }).then(res=>{
                if(res.data.success === false) alert(res.data.msg)
                delete this.uploading[file.name];
                this.files.push(res.data.file_name);
            });
        },
        openFile(){
            const fileUrl = this.path+'/'+this.chosenFile[0];
            const link = document.createElement('a');
            link.href = fileUrl;
            link.setAttribute('download', '');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

        },
        chooseFile(){
            this.$emit('chosenFiles',[...this.chosenFile]);
            let links = [...this.chosenFile];
            for(let i = 0; i <this.chosenFile.length;i++){
                links[i] = this.path+'/'+this.chosenFile[i];
            }

            this.$emit('chosenFilesLinks',[...links]);
        },
        deleteSelected(){
            if(this.chosenFile.length == 0) {alert('No file selected');return;}
            let toDelete = [];
            this.chosenFile.forEach(el=>{
                axios.post('files/delete?path='+this.relativePath+'/'+el);
                toDelete.push(el);
            });

            for(let i = 0; i < toDelete.length; i++){
                this.files.splice(this.files.indexOf(toDelete[i]),1);
            }
            
            this.chosenFile = [];
        }
    }
})
</script>

<style scoped>
.filemngr_cont{background:#f9f9f9;font-family: sans-serif;}
.filemng_top_ctrl{padding: 20px;}
.filemng_top_ctrl button{padding: 10px;border-radius: 10px;transition: 0.2s;border:none;margin: 5px;}
.filemng_top_ctrl button:hover{transform:scale(0.9);}
.filemng_top_ctrl .bulkSelect{border: 2px solid #2095db;background: #fff;color: #2095db;}
.filemng_top_ctrl .buttonActive{color:#fff;background:#2095db}
.filemng_top_ctrl .keepName{border: 2px solid #539895;background: #fff;color: #539895;}
.filemng_top_ctrl .keepNameActive{color:#fff;background:#539895}
.filemng_top_ctrl .delete{color: #fff;background: #85382a;border: 2px solid #85382a;}
.filemng_top_ctrl .view{color: #fff;background: #525252;border: 2px solid #525252;}
.filemng_top_ctrl .choose{color: #fff;background: #3b9160;border: 2px solid #3b9160;}

.filemngr_vwr{display:flex;flex-wrap:wrap;padding: 10px;gap:10px;justify-content: flex-start;}
.filemngr_vwr_itm{width: 11%;}
.filemngr_vwr_itm label{display: block;}
.filemngr_itm_disp{aspect-ratio: 1/1;}

.filemngr_vwr_itm:hover .filemngr_itm_disp{box-shadow: inset 0 0 5px #999;}
.filemngr_vwr_itm:active .filemngr_itm_disp,.filemngr_vwr_itm.active .filemngr_itm_disp{outline:1px solid #555;}
.filemngr_itm_disp{width:100%;aspect-ratio:1/1;background:#fff;border:1px solid #ddd;transition:0.2s;position: relative;}
.filemngr_itm_disp.upload{display: flex;justify-content: center;align-items: center;background: #aaa;color: #fff;font-size: 20px;font-family: sans-serif;}

.filemngr_itm_name{width:100%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;transition:0.2s;font-family: sans-serif;margin:10px 0;text-align: center;}
.filemngr_itm_disp img{object-fit: cover;width:100%;height: 100%;position: absolute;top: 50%;left:50%;transform: translateY(-50%) translateX(-50%);}
.filemngr_itm_disp .fileicon,.filemngr_itm_disp .playicon,.filemngr_itm_disp .uploadicon{height: 30px;position: absolute;top: 50%;transform: translateY(-50%)translateX(-50%);display: block;object-fit: contain;}
.filemngr_vwr_itm:hover .uploadicon{animation-name: bounce;animation-duration: 0.5s;}
.filemngr_itm_disp .selectInd{height: 20px;width:20px;position: absolute;top: 5px;left:5px;display: block;border-radius: 50%;padding:2px;box-shadow: 0 0 2px #000;transform: none;background: #fff;z-index: 1;}
.hoverTitle{padding: 10px;height: 100%;display: block;background: #f9f9f9;border-top:1px solid #aaa;overflow:hidden;white-space: nowrap;text-overflow: ellipsis;}

@keyframes bounce {
    0%{transform: translateX(-50%) translateY(-50%);}
    40%{transform: translateX(-50%) translateY(-100%);}
    60%{transform: translateX(-50%) translateY(-50%);}
    80%{transform: translateX(-50%) translateY(-70%);}
    100%{transform: translateX(-50%) translateY(-50%);}
}


@media only screen and (max-width:1000px){
    .filemngr_vwr_itm{width: 14%;}
}

@media only screen and (max-width:800px){
    .filemngr_vwr_itm{width: 23%;}
}

@media only screen and (max-width:600px){
    .filemngr_vwr_itm{width: 31%;}
    .filemng_top_ctrl{text-align: center;}
}

@media only screen and (max-width:400px){
    .filemngr_vwr_itm{width: 48%;}
    .filemng_top_ctrl button{width: 47%;}
}


</style>