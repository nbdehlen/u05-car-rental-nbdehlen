// Check Personal number last digit is valid

function controlPn() {
    const pn = document.querySelector("#personnummer").value;
    let pnStr = pn.toString();
    let digits = 0;
    for (let i = 0; i < pnStr.length - 1; i++) {
        if (i % 2 == 0) {
            if (pnStr.charAt(i) * 2 > 9) {
                temp1 = pnStr.charAt(i) * 2;
                temp2 = temp1.toString();
                digits += Number(temp2.charAt(0));
                digits += Number(temp2.charAt(1));
            } else {
                digits += pnStr.charAt(i) * 2;
            }
        } else {
            digits += Number(pnStr.charAt(i));
        }
    }

    let lastDigit = (10 - (digits % 10)) % 10;
    if (pnStr.slice(-1) != lastDigit) {
        alert("Felaktig kontrollsiffra" + lastDigit + "   " +digits);
        return false;
    } 

    const tel = document.querySelector("#telefonnummer").value;
    const telStr = String(tel);
    const teleMatch = telStr.charAt(0);
    const pnReq = /[0-9]{2}(?:0[1-9]|1[12])[0-3][0-9][0-9]{4}/g;
    const pnMatch = pn.match(pnReq);

    if (teleMatch == 0 && telStr.length == 10) {
        if (pnMatch == pn && pn.length == 10) {
            alert("Kund tillagd/ändrad i registret");
            return true;
        } else {
            alert("Felaktigt personnummer" + pn);
            return false;
        }
    }
    alert("Telefonnumret måste börja med en nolla och innehålla exakt 10 nummer");
    return false;
}

function addCustomerCtrl() {
    const pn = String(document.querySelector("#personnummer").value);
    const tel = document.querySelector("#telefonnummer").value;
    const telStr = String(tel);
    const pnReq = /[0-9]{2}(?:0[1-9]|1[12])[0-3][0-9][0-9]{4}/g;
    const pnMatch = pn.match(pnReq);

    const teleMatch = telStr.charAt(0);
    //const teleReq = /^0/g;
    //const teleMatch = String(tel).match(teleReq);

    if (teleMatch == 0 && telStr.length == 10) {
        if (pnMatch == pn && pn.length == 10) {
            alert("Kund tillagd/ändrad i registret");
            return true;
        } else {
            alert("Felaktigt personnummer1" + pn);
            return false;
        }
    }
    alert("Telefonnumret måste börja med en nolla och innehålla exakt 10 nummer");
    return false;
}

function addCarCtrl() {
    const reg = document.querySelector("#Registration").value;
    const year = Number(document.querySelector("#year").value);
    const price = document.querySelector("#price").value;

    const regReq =/[A-Za-z]{3}[0-9]{3}/g;
    const regMatch = reg.match(regReq);

    const yearReq = year >= 1900 && year <= 2020;

    const priceReq = Number(price) > 0;

    const badWords = "APA, ARG, ASS, BAJ, BSS, CUC, CUK, DUM, ETA, ETT, FAG, FAN, FEG, FEL, FEM, FES, FET, FNL, FUC, FUK, FUL, GAM, GAY, GEJ, GEY, GHB, GUD, GYN, HAT, HBT, HKH, HOR, HOT, KGB, KKK, KUC, KUF, KUG, KUK, KYK, LAM, LAT, LEM, LOJ, LSD, LUS, MAD, MAO, MEN, MES, MLB, MUS, NAZ, NRP, NSF, NYP, OND, OOO, ORM, PAJ, PKK, PLO, PMS, PUB, RAP, RAS, ROM, RPS, RUS, SEG, SEX, SJU, SOS, SPY, SUG, SUP, SUR, TBC, TOA, TOK, TRE, TYP, UFO, USA, WAM, WAR, WWW, XTC, XTZ, XXL, XXX, ZEX, ZOG, ZPY, ZUG, ZUP, ZOO";

    const badArr = badWords.split(", ", 200);
    let letterReg = reg.slice(0,3);

    if (regMatch) {
        if (yearReq) {
            for (let i=0; i<badArr.length; i++) {
                if (letterReg.match(badArr[i])) {
                    alert("Bra skämt, försök igen")
                    return false;
                } else if (!priceReq) {
                    alert("Priset måste vara ett positivt tal");
                    return false;
                }
            }

            alert("Bil tillagd/ändrad i registret");
            return true;
        } else {
            alert("Tillverkaråret måste vara mellan år 1900 och 2020");
            return false;
        } 
    }
    alert("Felaktigt registreringsnummer");
    return false;
}

/*



//const reg = document.querySelector("#Registration").value;

const reg = "FEG123";
const badArr = badWords.split(", ", 200);
let letterReg = reg.slice(0,3);

for (let i=0; i<badArr.length; i++) {
    if (letterReg.match(badArr[i])) {
        alert("Bra skämt, försök igen")
        return false;
    }
}*/