/* Check Personal number last digit is valid by multiplying every even number
   with 1 and every odd number with 2. if result from odd number is double digits
   it gets split into two single digits (Example: 6*2 = 12 would become 1,2).
   the output gets ran through the Lugn algorithm and matched with the last digit
   of the personal number.

   Javascript Date function rolls over to next month if input days are larger than 
   the amount of days in input month.
   Example of how JS interpets dates: new Date(2014, 04, 54) becomes "Mon Jun 23 2014"
   As we are not allowed to use frameworks I made a custom implementation.
*/

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
        alert("Felaktig kontrollsiffra " + lastDigit + "   " +digits);
        return false;
    } 

    const pnYear = pn.slice(0,2);
    const pnMd = pn.slice(2,6);
    let invalidDates = ["0230","0231","0431","0631","0931","1131"];

    /*Days of month validation
    Push 29th feb to list of invalid dates if birth year is not a leap year.*/
    function dateValidation() {
        if (!leapYear()) {invalidDates.push("0229")}; 

            for (let i=0; i<invalidDates.length ;i++) {
               if (invalidDates[i].match(pnMd)) {
                   return false;
               };
            }
            return true;
        }

    function leapYear() {
        for (let i=0; i < 100; i+=4) {
            if (pnYear == i) {
                return true;
            }
        }
        return false;
    }

    const tel = document.querySelector("#telefonnummer").value;
    const telStr = String(tel);
    const teleMatch = telStr.charAt(0);
    // Match year, month, day up to 31 followed by any 4 numbers
    const pnReq =
    /[0-9]{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[1-2][0-9]|3[0-1])[0-9]{4}/g;
    const pnMatch = pn.match(pnReq);

    if (teleMatch == 0 && telStr.length == 10) {
        if (pnMatch == pn && pn.length == 10 && dateValidation()) {
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

function addCustomerCtrl() {}

function addCarCtrl() {
    const reg = document.querySelector("#Registration").value;
    const year = Number(document.querySelector("#year").value);
    const price = document.querySelector("#price").value;

    //Match start with 3 letters, ending with 3 numbers
    const regValid =/^[A-Z]{3}[0-9]{3}$/gm;
    const regMatch = reg.match(regValid);

    const yearReq = year >= 1900 && year <= 2020;

    const priceReq = Number(price) > 0;

    //String of letter groups that cant be used on reg plate
    const badWords = "APA, ARG, ASS, BAJ, BSS, CUC, CUK, DUM, ETA, ETT, \n\
    FAG, FAN, FEG, FEL, FEM, FES, FET, FNL, FUC, FUK, FUL, GAM, GAY, GEJ, \n\
    GEY, GHB, GUD, GYN, HAT, HBT, HKH, HOR, HOT, KGB, KKK, KUC, KUF, KUG, \n\
    KUK, KYK, LAM, LAT, LEM, LOJ, LSD, LUS, MAD, MAO, MEN, MES, MLB, MUS, \n\
    NAZ, NRP, NSF, NYP, OND, OOO, ORM, PAJ, PKK, PLO, PMS, PUB, RAP, RAS, \n\
    ROM, RPS, RUS, SEG, SEX, SJU, SOS, SPY, SUG, SUP, SUR, TBC, TOA, TOK, \n\
    TRE, TYP, UFO, USA, WAM, WAR, WWW, XTC, XTZ, XXL, XXX, ZEX, ZOG, ZPY, \n\
    ZUG, ZUP, ZOO";

    /* Remove linebreakers/special chars, Split string to array by comma, 
    trim whitespace from returned array inside loop. 
    Slice the first 3 letters from input reg plate and iterate to find a match */
    
    const bwFilter = /[^\x20-\x7E]/gmi;
    const noBreaksBadWords = badWords.replace(bwFilter,'');
    const badArr = noBreaksBadWords.split(",", 200);
    const letterReg = reg.slice(0,3);
    
    if (regMatch) {
        
        if (yearReq) {
            let badArrTrim = [];
            //Checking for bad words in reg plate
            for (let i=0; i<badArr.length; i++) {
                badArrTrim[i] = badArr[i].trim();
                if (letterReg.match(badArrTrim[i])) {
                    alert("Bra skämt, försök igen");
                    return false;
                } else if (!priceReq) {
                    alert("Priset måste vara ett positivt tal");
                    return false;
                }
            }

            alert("Bil tillagd/ändrad i registret");
            return true;
        } else {
            alert("Tillverkningsåret måste vara mellan år 1900 och 2020");
            return false;
        } 
    }
    alert("Felaktigt registreringsnummer. Kräver 3 stora bokstäver, \n\
    3 siffror och inga otillåtna bokstavskombinationer");
    return false;
}