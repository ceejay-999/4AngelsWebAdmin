import encHex from 'crypto-js/enc-hex';
import encUtf8 from 'crypto-js/enc-utf8';
import crypto from 'crypto-js/core';
import aes from 'crypto-js/aes';


const passphrase = "&#proweaverkim2020;";
const CryptoJSAesJson = {
    stringify: function (cipherParams) {
        var j = {ct: cipherParams.ciphertext.toString(crypto.enc.Base64)};
        if (cipherParams.iv) j.iv = cipherParams.iv.toString();
        if (cipherParams.salt) j.s = cipherParams.salt.toString();
        return JSON.stringify(j);
    },
    parse: function (jsonStr) {
        var j = JSON.parse(jsonStr);
        var cipherParams = crypto.lib.CipherParams.create({ciphertext: crypto.enc.Base64.parse(j.ct)});
        if (j.iv) cipherParams.iv = encHex.parse(j.iv)
        if (j.s) cipherParams.salt = encHex.parse(j.s)
        return cipherParams;
    }
}

export function encrypt(data){
    let obj = JSON.parse(aes.encrypt(JSON.stringify(data), passphrase, {format: CryptoJSAesJson}).toString());
    obj.du = obj.ct; 
    obj.jw = obj.iv;
    obj.t =  obj.s;
    delete obj.ct;
    delete obj.iv;
    delete obj.s
    let enc = `${obj.du}%sEp:;${obj.jw}%sEpEr:;${obj.t}`
    return enc;
}

export function decrypt(enc){
    enc = enc.split(/(%sEp:;|%sEpEr:;)/);
    let data = {
        ct:enc[0],
        iv:enc[2],
        s:enc[4]
    };

    let decrypted = JSON.parse(aes.decrypt(JSON.stringify(data), passphrase, {format: CryptoJSAesJson}).toString(encUtf8));
    return decrypted;
}

export function objectify(enc){
    return JSON.parse(decrypt(enc));
}





