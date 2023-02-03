<template>
    <div class="table_cont" :data-table="data_prefix">
        <div class="table_ctrl">
            <div>
                Results:
                <select>
                    <option @click="pageSize(10)">10</option>
                    <option @click="pageSize(25)">25</option>
                    <option @click="pageSize(50)">50</option>
                    <option @click="pageSize(100)">100</option>
                    <option @click="pageSize(250)">250</option>
                    <option @click="pageSize(500)">500</option>
                    <option @click="pageSize(fetch.count ?? 0)">All</option>
                </select>
            </div>
    
            <button @click="genXLSXTable" class="btn btn-primary">Export</button>
    
            
        </div>
        <table v-if="data != null && data.length != 0" id="DataTable_Element">
            <thead>
                <tr>
                    <th v-for="cn,i in columnNames" :key="cn">
                        <img title="Ascending" v-if="(i != columnNames.length - 1 && columnNames.length > columns.length) || columnNames.length == columns.length" @click="orderby(orderNames[columns[i]] ?? columns[i],'ASC');goToPage(1)" src="../../assets/caret-down.svg" class="caret-up">
                        <img title="Descending" v-if="(i != columnNames.length - 1 && columnNames.length > columns.length) || columnNames.length == columns.length" @click="orderby(orderNames[columns[i]] ?? columns[i],'DESC');goToPage(1)" src="../../assets/caret-down.svg" class="caret-down">
                        {{cn}}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d,i in data" :key="i">
                    <td v-for="c,ic in columns" v-html="processValues(d)[c]" :key="ic"></td>
                    <td><slot :data="d" /></td>
                </tr>
            </tbody>
         </table>
         <h6 v-if="data == null || data.length == 0">No data available...</h6>
    
         <div class="segment_buttons" v-if="fetch != null">
            <button v-for="i in fetch.maxSegments" :key="i" @click="goToPage(i)" :class="{current: (i-1) == fetch.currentSegment}">{{i}}</button>
        </div>
    </div>
        
    </template>
    
    <script>
    import {SegmentedFetch} from '../../functions'
    import {utils,writeFileXLSX} from 'xlsx';
    
    export default {
        props:{
            use: String,
            url: String,
            searchfrom: String,
            labels: String,
            format: Object
        },
        data(){
            return {
                columns:[],
                columnNames:[],
                fetch:null,
                data:[],
                data_prefix:'',
                addedPrefix:'',
                orderNames:{},
                order:[],
                currentPage:0
            }
        },
        watch:{
            url(change){
                this.fetch = new SegmentedFetch(change);
            }
        },
        created(){
            this.data_prefix = Math.floor(Math.random() * 1000).toString(32)+(new Date().getTime().toString(32));   
        },
        mounted(){
            this.fetch = new SegmentedFetch(this.url);
            this.columnNames = this.labels.split(',');
            this.columns = this.use.split(',');
            this.goToPage(1);
    
            // setInterval(()=>{
            //     this.goToPage(this.currentPage);
            // },1000);
        },
        methods:{
            orderby(column,dir){
                this.order = [column,dir];
                console.log(column,dir);
                this.addedPrefix = '&_orderedby='+column+'_'+dir;
            },
            async goToPage(num){
                this.currentPage = num;
                num--;
                let res = await this.fetch.fetch(num,this.addedPrefix);
                this.data = res.data.result
            },
            async pageSize(num){
                this.fetch.pageSize(num);
                this.goToPage(1)
            },
            genXLSXTable(){
                const table = document.getElementById("DataTable_Element");
                const wb = utils.table_to_book(table);
                writeFileXLSX(wb,`speedyrepair-${new Date().getTime()}.xlsx`);
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
    
                    if(this.format[c].orderName != null){
                        this.orderNames[c] = this.format[c].orderName;
                    }else{
                        this.orderNames[c] = c;
                    }
                }
    
                return el;
            }
            
        }
    }
    </script>
    <style scoped>
    table{width:100%;border-collapse: collapse;border:1px solid #e2e2e2}
table th,table td{padding:10px;border:1px solid #e2e2e2;line-height: 100%;}
table tr:nth-of-type(even) td{background: #ededed;}
table tr:hover td{background: #ddd;}
.segment_buttons button{
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 50%;
    width: 27px;
    height: 27px;
    line-height: 100%;
    padding: 4px;
    margin: 0 2px;
    transition: 0.2s;
}

.segment_buttons{margin-top: 10px;}
.segment_buttons button:hover{scale: 0.90;}
.segment_buttons button.current,.segment_buttons button:active{border: 1px solid #444;background:#444;color:#fff}
.table_ctrl{display: flex;gap:20px;margin: 0 0 20px;}
.caret-up,.caret-down{width: 18px;height: 18px;margin: 2px;padding:5px;box-shadow: 0 0 2px #777;border-radius: 50%;transition:0.2s}
.caret-up{rotate: 180deg;}
.caret-down{margin-right: 5px;}
.caret-up:hover,.caret-down:hover{scale:1.2}
.table_ctrl select{
    background: #fff;
    border: 1px solid #ccc;
    outline: none;
    margin-left: 5px;
    border-radius: 5px;
}

h6{text-align: center;padding: 10px 0;border:1px solid #e2e2e2;}
    </style>
