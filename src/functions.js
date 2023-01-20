// import './jspdf.min.js';
import axiosA from 'axios';
import { encrypt, decrypt } from './crypto';

function elementLoad(selector) {
    return new Promise(resolve=>{
        var check = setInterval(function() {
            if (document.querySelector(selector) != null) {
                clearInterval(check);
                resolve(document.querySelector(selector));
            }
        }, 100);
    })
}

function optimizeImage(src) {
    let cnv = document.createElement('canvas');
    document.body.appendChild(cnv);
    let ctx = cnv.getContext('2d');
    let img = new Image();
    const maxdim = 700;
    img.src = src;

    return new Promise((resolve) => {img.onload = ()=>{
        if (img.width >= img.height) {
            cnv.width = maxdim;
            cnv.height = maxdim * (img.height / img.width);
        } else {
            cnv.height = maxdim;
            cnv.width = maxdim * (img.width / img.height);
        }
            ctx.drawImage(img, 0, 0,cnv.width,cnv.height);
            const cdata = cnv.toDataURL();
            cnv.remove();
            resolve(cdata);
        }
    });
}

function validateForm(obj,rules) {
    let validated = {
        allValid: true
    };
    
    for (let r in rules) {
        if ((rules[r] == "required" || rules[r].isRequired ) &&
            obj[r] == undefined || obj[r] == '' ) {
                validated[r] = 'empty';
        } else if ((rules[r] != "required" || rules[r].isRequired ) &&
            obj[r] == undefined || obj[r] == '' ) {
                validated[r] = true;  
        } else if (r != 'callback') {
            let emailregex = /[a-z0-9._]+@[a-z]+\.[a-z]{2,3}/i;
            let intregex = /[0-9]+/;
            let floatregex = /[0-9]+.[0-9]+/;

            validated[r] = true;

            if (rules[r].isEmail &&  obj[r].toLowerCase().match(emailregex))
                validated[r] = true;
            else if (rules[r].isEmail ) {
                validated[r] = 'invalid_email';
                break;
            }

            if (rules[r].isInteger && obj[r].match(intregex))
                validated[r] = true;
            else if (rules[r].isInteger) {
                validated[r] = 'invalid_number';
                break;
            }

            if (rules[r].isFloat && (obj[r].match(floatregex) || obj[r].match(intregex)))
                validated[r] = true;
            else if (rules[r].isFloat) {
                validated[r] = 'invalid_number';
                break;
            }

            if (rules[r].regexMatch != null && obj[r].match(rules[r].regexMatch))
                validated[r] = true;
            else if (rules[r].regexMatch != null) {
                validated[r] = 'value_and_regex_not_match';
                break;
            }

            if (rules[r].equalTo != null &&  obj[r] == rules[r].equalTo)
                validated[r] = true;
            else if (rules[r].equalTo != null) {
                validated[r] = 'values_not_match';
                break;
            }

            if (typeof rules[r].maxChars == 'number' && rules[r].maxChars >= obj[r].length)
                validated[r] = true;
            else if (typeof rules[r].maxChars == 'number') {
                validated[r] = 'invalid_length_max';
                break;
            }

            if (typeof rules[r].minChars == 'number' && rules[r].minChars <= obj[r].length)
                validated[r] = true;
            else if (typeof rules[r].minChars == 'number') {
                validated[r] = 'invalid_length_min';
                break;
            }
        }
    }

    let someEmpty = false;

    if (rules.callback != null) {
        for (let v in validated) {
            if (validated[v] === 'empty') {
                validated.allValid = false;
                rules.callback();
                someEmpty = true;
                break;
            }
        }
    }

    if (!someEmpty) {
        for (let v in validated) {
            if (validated[v] != true) {
                validated.allValid = false;
                if (rules[v].callback != null) {
                    rules[v].callback(validated[v],v);
                    break;
                }
            }
        }
    }

    return validated;
}


// function toPdf(selector,saveAs,marg=undefined) {
//     var pdf = new jsPDF('p', 'pt', 'letter');

//     source = document.querySelector(selector);

//     specialElementHandlers = {

//         '#bypassme': function (element, renderer) {

//             return true
//         }
//     };
//     margins = (marg != undefined) ? marg : {
//         top: 20,
//         bottom: 20,
//         left: 20,
//         width: 500
//     };


//     pdf.fromHTML(
//         source,
//         margins.left,
//         margins.top, {
//             'width': margins.width,
//             'elementHandlers': specialElementHandlers
//         },

//         function (dispose) {       
//             pdf.save(saveAs);
//         }, margins
//     );
// }



function toFormData(obj) {
    var fd = new FormData();
    for (var i in obj) {
        fd.append(i,obj[i]);
    }
    return fd;
}

function formatDateString(dateString) {
    let digits = dateString.matchAll(/[0-9]+/g);
    let digitsArr = [];

    for (const d of digits) {
        if (new String(d).length == 1) digitsArr.push("0" + d);
        else digitsArr.push(d);
    }

    let newString = '';

    for (let i = 0; i < digitsArr.length; i++) {
        if (i < 2) newString = newString + digitsArr[i] + "-";
        else if (i == 2) newString = newString + digitsArr[i] + " ";
        else if (i > 2 && i != digitsArr.length-1) newString = newString + digitsArr[i] + ":";
        else if (i == digitsArr.length-1) newString = newString + digitsArr[i];
    }

    return newString;
}

function dateFormat(stringFormat, dateString) {
    let dateParse = dateString.match(/([0-9]+-[0-9]+-[0-9]+ [0-9]+:[0-9]+:[0-9]+)|([0-9]+:[0-9]+:[0-9]+)|([0-9]+-[0-9]+-[0-9]+)/g)[0];
    dateParse = dateParse.replaceAll('-','/');
    let date = new Date(Date.parse(dateParse));
    let months = ['January','February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    let dateFormat = stringFormat.replaceAll('%y',date.getFullYear());
    dateFormat = dateFormat.replaceAll('%d',date.getDate());
    dateFormat = dateFormat.replaceAll('%lm',months[date.getMonth()]);
    dateFormat = dateFormat.replaceAll('%sm',months[date.getMonth()].substring(0,3));
    dateFormat = dateFormat.replaceAll('%m',date.getMonth());
    dateFormat = (date.getMinutes() >= 10) ?  dateFormat.replaceAll('%i',date.getMinutes()) : dateFormat.replaceAll('%i',"0"+date.getMinutes());
    dateFormat = (date.getSeconds() >= 10) ?  dateFormat.replaceAll('%s',date.getSeconds()) : dateFormat.replaceAll('%s',"0"+date.getSeconds());
    let hour = date.getHours();
    if (hour > 12) {
        dateFormat = dateFormat.replaceAll('%h',hour - 12);
        dateFormat = dateFormat.replaceAll('%a','PM');
    } else if (hour == 0) {
        dateFormat = dateFormat.replaceAll('%h',12);
        dateFormat = dateFormat.replaceAll('%a','AM');
    } else {
        dateFormat = dateFormat.replaceAll('%h',hour);
        dateFormat = dateFormat.replaceAll('%a','AM');
    }
    dateFormat = dateFormat.replaceAll('%H',hour);
    return dateFormat;
}

function removeFix(object,fix) {
    let newObj = {};
    
    for (let k in object) {
        let key = k.toLowerCase().replaceAll(fix,""); 
        newObj[key] = object[k];
    }

    return newObj;
}

class LocalStore {
    set(key,value) {localStorage.setItem(key,value);}
    get(key) {return localStorage.getItem(key);}
    setObject(key,value) {localStorage.setItem(key,JSON.stringify(value));}
    getObject(key) {return JSON.parse(localStorage.getItem(key));}
    remove(key) {localStorage.removeItem(key);}
    setInObject(parentKey,childKey,value) {
        let parentObject = this.getObject(parentKey);
        parentObject[childKey] = value;
        this.setObject(parentKey,parentObject);
    }
    isset(key) {
        if (localStorage.getItem(key) == null) return false;
        return true;
    }
    getInObject(parentKey,childKey) {
        let parentObject = this.getObject(parentKey);
        return parentObject[childKey];
    }
    objectify(stringObj) {
        stringObj = stringObj.replaceAll('&#34;','"');
        stringObj = JSON.parse(stringObj);
        return stringObj;
    }
}

const local = new LocalStore();

function toDataURL(file) {
    const filereader = new FileReader();
    filereader.readAsDataURL(file);
    return new Promise((resolve) => {
        filereader.addEventListener('load',() => {
            resolve(filereader.result);
        });
    });
}

class AsyncStorage {
    constructor() {
        this.storage = {};
    }
    
    set(key,val) {
        if (!key.includes('.')) {
            this.storage[key] = val;
            if (typeof val == 'object') localStorage.setItem('async_'+key, JSON.stringify(val));
            else localStorage.setItem('async_'+key,val);  
        } else {
            var schema = this.storage;
            var pList = key.split('.');
            var len = pList.length;
            for (var i = 0; i < len-1; i++) {
                var elem = pList[i];
                if ( !schema[elem] ) schema[elem] = {}
                schema = schema[elem];
            }
        
            schema[pList[len-1]] = val;
            localStorage.setItem('async_'+pList[0], JSON.stringify(this.storage[pList[0]]));
        }
    }

    get(key) {
        if (isJsonString(localStorage.getItem('async_'+key))) return JSON.parse(localStorage.getItem('async_'+key));
        else return localStorage.getItem('async_'+key);
    }

    isset(key) {
        if (localStorage.getItem('async_'+key) == null) return false;
        return true;
    }
    
    remove(key) {
        delete this.storage[key];
        localStorage.removeItem('async_'+key);
    }

    objectify(stringObj) {
        stringObj = stringObj.replaceAll('&#34;','"');
        stringObj = JSON.parse(stringObj);
        return stringObj;
    }
}

// COMP FUNCTIONS FOR ASYNCSTORAGE
window.onload = ()=>{
    for (let s in localStorage) {
        if (s.includes('async_')) {lStore.storage[s.replaceAll('async_','')] = localStorage.getItem(s);}
    }
}

function isJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

const lStore = new AsyncStorage();
// END OF COMP FUNCTIONS FOR ASYNCSTORAGE

function bubbleSort(array,conditionCallback) {
    let sortedArray = array;
    for (let i = 0; i < sortedArray.length; i++) { 
        for (let j = 0; j < ( sortedArray.length - i -1 ); j++) {
            if (conditionCallback(array[i], array[j])) {
                let temp = sortedArray[j]
                sortedArray[j] = sortedArray[j + 1]
                sortedArray[j+1] = temp
            }
        }
    }

    return sortedArray;
}

function calcFlyDist(coors1, coors2) {
    if ((coors1[0] == coors2[0]) && (coors1[1] == coors2[1])) {
        return 0;
    } else {
        var radlat1 = Math.PI * coors1[0]/180;
        var radlat2 = Math.PI * coors2[0]/180;
        var theta = coors1[1]-coors2[1];
        var radtheta = Math.PI * theta/180;
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        if (dist > 1) {
            dist = 1;
        }
        dist = Math.acos(dist);
        dist = dist * 180/Math.PI;
        dist = dist * 60 * 1.1515;
        dist = dist * 1.609344;
        return dist;
    }
}

function escapeHtml(unsafe) {
    return unsafe
    .replace("&amp;", '&')
    .replace("&lt;", '<')
    .replace("&gt;", '>')
    .replace("&quot;", '"')
    .replace("&#39;", "'");
}

export class SegmentedFetch {
    constructor(url, headers=null, body=null, callback=null) {
        this.count = 0;
        this.index = 0;
        this.segSize = 0;
        this.maxSegs = 0;
        this.request = {
            method: 'post',
            url,
            headers,
            body
        };
        if(!this.request.url.includes('?')) this.request.url += '?';
        axios.encrypted(this.request.url.replaceAll(/(?!(?:&_joins=[\w,:_ ]+|&_on=[\w,:_ ]+|&_searchconcat=[\w,:_ ]+|&_searchfrom=[\w,:_ ]+|&_search=[\w,:_ ]+))(\&_[a-zA-Z_]+=[\w,:_ ]+|\?_[a-z]+=[\w,:_ ]+)/g,'')+'&_select=count(*)',headers,body).then(res=>{
            res.data = axios.decryptToJSON(res.data);
            
            if (res.data == false) return;
            this.count = res.data.result['count(*)'];
            if (callback != null) callback(this);
        });
    }

    segmentSize(divInto) {
        this.segSize = divInto;
        this.maxSegs = Math.ceil(this.count / divInto);
        return this.maxSegs;
    }

    currentSegment() {
        return this.index / this.segSize;
    }

    fetch(segment=null) {
        if (segment != null) {
            if (segment<this.maxSegs) this.index = this.segSize * segment;
            else return;
        }
        let tempObj = {...this.request};
        tempObj.url = this.request.url+`&_offset=${ this.index }&_limit=${ this.segSize }&_batch=true`;
        this.index += this.segSize;
        
        return new Promise(resolve=>{
            axios.encrypted(tempObj.url.replaceAll(axios.baseUrl,''),
                this.request.headers,
                this.request.body)
            .then(res=>{
                res.data = axios.decryptToJSON(res.data);
                if (res.data == false) return;
                resolve(res);
            });
        });
        
    }
}

class AxiosR{
    constructor(baseUrl) {
        this.baseUrl = baseUrl;
        this.defHeaders = { PWAuth: lStore.get('user_token'), PWAuthUser: lStore.get('user_id') };
    }

    get(endpoint) {
        return axiosA({
            method:'get',
            url: endpoint
        });
    }

    async post(endpoint,headers=null,body=null,opts={}) {
        
        let params = {
            method:'post',
            url: this.baseUrl+endpoint
        };

        if (headers == 'default') params["headers"] = this.defHeaders
        else if (headers!=null) params["headers"] = headers;
        
        if (body!=null) params["data"] = toFormData(body);
        params = {...params,...opts};
        return axiosA(params);
    }

    decryptToJSON(enc) {
        try {
            let resp = JSON.parse(decrypt(enc));
            return resp;
        } catch(err) {
            return false;
        }
    }
    
    async encrypted(getReq,headers=null,body=null,opts={}) {
        let endpoint = getReq.split('?')[0];
        let encbody = {};
        if (getReq.split('?').length > 1) {
            getReq = encrypt(getReq.split('?')[1]);
            encbody.get_data = getReq;
        }
        if (body!=null) {
            let post_data = '';
            let count = 0;
            for (let b in body) {
                if (count == Object.keys(body).length-1) {
                    body[b] = String(body[b]);
                    body[b] = body[b].replaceAll('&','%26');
                    post_data += `${b}=${body[b]}`;
                    
                } else {
                    body[b] = String(body[b]);
                    body[b] = body[b].replaceAll('&','%26');
                    post_data += `${b}=${body[b]}&`;
                }
                count++;
            }
            encbody.post_data = encrypt(post_data);
        }
        
        return this.post(endpoint,headers,encbody,opts);
    }
}

const axios = new AxiosR('https://www.4angelshc.com/mobile/');

export {
    validateForm,
    toFormData,
    local,
    dateFormat,
    removeFix,
    toDataURL,
    optimizeImage,
    elementLoad,
    formatDateString,
    lStore,
    bubbleSort,
    calcFlyDist,
    escapeHtml,
    axios
}; 