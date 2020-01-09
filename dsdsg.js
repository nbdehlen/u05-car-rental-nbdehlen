let pn = "0411210341";
const pnYear = pn.slice(0,2);
const pnMd = pn.slice(2,6);
let invalidDates = ["0230","0231","0431","0631","0931","1131"];

function leapYear() {
    for (let i=0; i < 100; i+=4) {
        if (pnYear == i) {
            return true;
        }
    }
    return false;
}

//Days of month validation
function dateValidation() {
    if (leapYear()) {invalidDates.push("0229")} 
        for (let i=0; i<invalidDates.length ;i++) {
               if (invalidDates[i].match(pnMd)) {
                   return true;
               };
            }
            return false;
        }

if (dateValidation()) {console.log("its truu")}
else {console.log("falseee")};