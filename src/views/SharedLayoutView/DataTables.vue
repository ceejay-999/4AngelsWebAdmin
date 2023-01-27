<template>
    <div class="dataTableCtrl">
        <div>
            Show Results:
            <select @change="segmentSizeChange" class="endSelect">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="75">75</option>
                <option value="100">100</option>
                <option value="All">All</option>
            </select>
        </div>

        <div>
            Order by:
            <select @change="e=>orderBy(e.target.value,orderDir)">
                <option v-for="u,i in useColumns" :key="u" :value="u">{{columnLabels[i]}}</option>
            </select>
            <select class="endSelect" @change="e=>orderBy(orderCol,e.target.value)">
                <option value="ASC">Ascending</option>
                <option value="DESC">Descending</option>
            </select>
        </div>
        <div>
            <button class="exportbtn" @click="saveTableSettings" v-if="!expMode">Export Table</button>
            <button class="exportbtn" @click="genXLSXTable" v-if="expMode">Export to XLSX</button>
        </div>

        <div v-if="!expMode">
            <input placeholder="Enter some keywords..." v-model="keyword">
            <button class="exportbtn" @click="search">Search</button>
        </div>
    </div>
    <div class="dataTableCont_container">
        <table class="dataTableCont" id="DataTable_Element">
        <thead class="dataTableHead">
            <th class="dataTableHeaders" v-for="(c) in columnLabels" :key="c">{{c}}
            </th>
        </thead>
        
        <tr class="dataTableCont" v-for="d in dataObj" :key="d.user_id">
            <td class="dataTableCell" v-for="c in useColumns" :key="d.user_id+'_'+c" v-html="isTypeDate(processValues(d)[c],'%lm %d, %y')"></td>
            <td class="dataTableCell" v-if="!(useColumns.length == 0 || useColumns[0] == '')"><slot :data="d" /></td>
        </tr>
    </table>
    <em class="nodata" v-if="dataObj.length == 0">No data available...</em>
    </div>
    
    <div class="segmentBtns">
        <button v-for="i in segments" :key="i" @click="setFetch(i)" :class="{current:segFetch.currentSegment() == i}">{{i}}</button>
    </div>
    
</template>

<script>    
import {SegmentedFetch,dateFormat,lStore} from '../../functions'
import {utils,writeFileXLSX} from 'xlsx';

export default({
    props:{
        url:String,
        columns:String,
        columnNames:String,
        formatValues:Object,
        generateMode:Boolean,
        searchOn:String,
        columnPrefix:String
    },
    data(){
        return{
            segFetch:null,
            dataObj: [],
            segments:0,
            segSize: 0,
            useColumns:[],
            columnLabels:[],
            orderDir:'ASC',
            orderCol: '',
            expMode: false,
            format:{},
            urlFetch:'',
            returnURL:'',
            keyword:''
        }
    },
    watch:{
        url(){
            this.urlFetch = this.url;
            this.dataObj = [];
            this.fetchData();
        }
    },
    mounted(){
        this.useColumns = this.columns;
        this.useColumns = this.useColumns.split(',');
        this.columnLabels = this.columnNames;
        this.columnLabels = this.columnLabels.split(',');
        this.orderCol = this.useColumns[0];
        this.expMode = this.generateMode == 'true';
        this.format = this.formatValues;
        this.urlFetch = this.url;
        if(this.expMode){
            let table_data = lStore.get('table_data');
            if(table_data.formatValues != null) this.format = JSON.parse(table_data.formatValues);
            this.urlFetch = table_data.url;
            this.returnURL = table_data.origin;
        }

        window.onresize = this.responsiveTable();
        
        this.fetchData();
    },
    methods:{
        dateFormat,
        saveTableSettings(){
            let tableData = {
                formatValues: JSON.stringify(this.formatValues),
                url: this.url,
                origin: this.$route.path
            };
            lStore.set('table_data',tableData);
            this.$router.push('/exporttable');
        },
        genXLSXTable(){
            const table = document.getElementById("DataTable_Element");
            const wb = utils.table_to_book(table);
            writeFileXLSX(wb,`speedyrepair-${new Date().getTime()}.xlsx`);
            setTimeout(()=>{
                lStore.remove('table_data');
                this.$router.replace(this.returnURL);
            },2000);
        },
        responsiveTable(){
            if(document.querySelectorAll('.dataTableCtrl').length <= 1) return;
            let container = document.querySelectorAll('.dataTableCtrl')[1];
            let containerWidth = container.offsetWidth;
            if(containerWidth <= 600){
                container.classList.add('width_600');
                container.classList.remove('width_1000');
            }else if(containerWidth <= 1000){
                container.classList.add('width_1000');
                container.classList.remove('width_600');
            }else{
                container.classList.remove('width_1000');
                container.classList.remove('width_600');
            }
        },
        processValues(el){
            el = JSON.parse(JSON.stringify(el));
            for(let c in this.format){
                if(this.format[c].currency != null){
                    let a = parseFloat(el[c]).toFixed(2);
                    el[c] = this.format[c].currency+a;
                }
    
                if(this.format[c].replace != null){
                    this.format[c].replace.forEach(el2=>{
                        let value = el[c];
                        el[c] = el[c].replaceAll(el2[0],el2[1]);
                        el[c] = el[c].replaceAll('__value__',value);
                    })
                }

                if(this.format[c].render != null){
                    let value = el[c];
                    el[c] = this.format[c].render(el[c],el)
                }
            }

            return el;
        },
        fetchData(){
            return new Promise(resolve=>{
                this.segFetch = new SegmentedFetch(this.urlFetch,'default',null,async ()=>{
                    this.segments = this.segFetch.segmentSize(10);
                    this.segSize = 10;
                    let res = await this.segFetch.fetch();
                    if(res.data.result == null) return;
                    this.dataObj = res.data.result;
                    //this.useColumns.length
                    if(this.useColumns.length == 0 || this.useColumns[0] == ''){
                        this.useColumns = Object.keys(this.dataObj[0]);
                        this.columnLabels = Object.keys(this.dataObj[0]);
                    }
                    this.responsiveTable();
                    resolve();
                });
            })
        },
        async setFetch(f=1){
            let res = await this.segFetch.fetch(f-1);
            if(res.data.result == null) return;
            this.dataObj=[];
            setTimeout(()=>this.dataObj = res.data.result,100);
            return;
        },
        isTypeDate(d,format){
            if(d==null) return d;
            let dateRegex = /([0-9]+-[0-9]+-[0-9]+ [0-9]+:[0-9]+:[0-9]+)|([0-9]+-[0-9]+-[0-9]+)|([0-9]+:[0-9]+:[0-9]+)/g;
            if(d.match(dateRegex) == null) return d;
            return dateFormat(format,d);
        },
        segmentSizeChange(e){
            this.dataObj = [];
            if(e.target.value == 'All') {
                if(confirm(`This action will load ${this.segFetch.count} records and might crash your browser. Continue?`)){
                    this.segSize = this.segFetch.count;
                    this.segments = 1;
                    this.segFetch.segmentSize(this.segSize);
                }
                else return;
            } 
            else {
                this.segSize = e.target.value;
                this.segments = this.segFetch.segmentSize(this.segSize);
            }
            
            this.setFetch();
        },
        orderBy(col,dir){
            col = col.replace(this.columnPrefix,'');
            this.orderCol = col;
            col = col.replaceAll('_','__');
            col = col+'_'+dir;
            this.segFetch = new SegmentedFetch(this.urlFetch+'&_orderby='+col,'default',null,async ()=>{
                this.segments = this.segFetch.segmentSize(this.segSize);
                let res = await this.segFetch.fetch(0);
                if(res.data.result == null) return;
                this.dataObj=[];
                setTimeout(()=>this.dataObj = res.data.result,100);
            });
        },
        search(){
            let searchOriginArray = this.searchOn.split(',');
            let concats = '';
            let froms = '';
            searchOriginArray.forEach(el=>{
                if(el.match(':') != null) concats+=','+el;
                else froms+=','+el;
            });

            this.segFetch.request.url = this.segFetch.request.url.replaceAll(/(?:&_searchconcat=[\w,:_ ]+|&_searchfrom=[\w,:_ ]+|&_search=[\w,:_ ]+)/g,'');
            
            this.segFetch = new SegmentedFetch(this.segFetch.request.url+`${(concats != '') ? '&_searchconcat='+concats.substring(1) : ''}${(froms != '') ? '&_searchfrom='+froms.substring(1) : ''}&_search=${this.keyword}`,'default',null,async ()=>{
                this.segments = this.segFetch.segmentSize(this.segSize);
                let res = await this.segFetch.fetch(0);
                if(res == null){this.dataObj = []; return}
                if(res.data.result == null) {this.dataObj = []; return}
                this.dataObj = [];
                setTimeout(()=>this.dataObj = res.data.result,100);
                
            });
        }
    }
})
</script>

<style scoped>
*{height: max-content !important;}
select{
    padding: 5px;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 0 5px;
    
}
.endSelect{
    margin-right: 20px;
}

.datatable[data-v-89e64447] {
  background: #fff;
}

.dataTableHeaders{text-align: center;}
.dataTableCont{width:100%;border-collapse: collapse;margin: 20px 0;}
.dataTableCell,.dataTableHeaders{padding: 10px;border-bottom: 1px solid #e3e3e2;border-right:1px solid #e3e3e2;}
.dataTableCell:last-child, .dataTableHeaders:last-child{border-right: none;}
.dataTableCont:last-child .dataTableCell{border-bottom: none;}

.dataTableCont:nth-of-type(even){background: #eee;}
.dataTableCont:hover > .dataTableCell{background: #f0f0f0;}
.dataTableCont:nth-of-type(even):hover > .dataTableCell{background: #e5e5e5;}
.segmentBtns button{
    padding: 5px;
    padding: 5px;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: 0.2s;
    margin: 0 2px;
}
.segmentBtns button:hover{background: #ccc;}
.segmentBtns button.current{
    background: #555;
    border: none;
    color: #fff;
}

.exportbtn{
    border: none;
    background: #2095db;
    padding: 10px;
    border-radius: 5px;
    color: #fff;
    font-weight: 500;
    transition: 0.2s;
    margin: 0 5px;
}

.nodata{text-align: center;display: block;}

.dataTableCont_container{overflow-x:auto;margin-bottom: 10px;}

.exportbtn:hover{background-color:#1a628b}
q{quotes: none;}

.dataTableCtrl{display: flex;align-items: center;}

@media only screen and (max-width:1000px) {
  .dataTableCtrl{justify-content: flex-start;gap:20px;align-items: flex-start;flex-wrap:wrap}
    .dataTableCtrl select{display: block;width: 100%;}
    .dataTableCtrl >div{width: 48%;}
}

@media only screen and (max-width:600px) {
    .dataTableCtrl >div{width: 100%;}
}

.width_1000.dataTableCtrl,.width_600.dataTableCtrl{justify-content: flex-start;gap:20px;align-items: flex-start;flex-wrap:wrap}
.width_1000.dataTableCtrl select,.width_600.dataTableCtrl select{display: block;width: 100%;}
.width_1000.dataTableCtrl >div,.width_600.dataTableCtrl >div{width: 48%;}

.width_600.dataTableCtrl >div{width: 100%;}

.dataTableCtrl div:last-child{
    margin-left: auto;
    display: grid;
    grid-template-columns: 3fr 1fr;
}

.dataTableCtrl input{
    padding: 10px;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 0 5px;
}


</style>


