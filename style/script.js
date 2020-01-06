function addCustomerCtrl() {
    const pn = document.querySelector("#personnummer").value;
    const tel = document.querySelector("#telefonnummer").value;

    const pnReq = /[0-9]{2}(?:0[1-9]|1[12])[0-3][0-9][0-9]{4}/g;
    const pnMatch = pn.match(pnReq);

    const teleReq = /^0/g;
    const teleMatch = tel.match(teleReq);

    if (teleMatch && tel.length == 10) {
        if (pnMatch && pn.length == 10) {
            alert("Kund tillagd i registret");
            return true;
        } else {
            alert("Felaktigt personnummer");
            return false;
        }
    }
    alert("Telefonnumret måste börja med en nolla och innehålla exakt 10 nummer");
    return false;
}

function addCarCtrl() {
    const reg = document.querySelector("#Registration").value;
    const year = Number(document.querySelector("#year").value);

    const regReq =/[A-Za-z]{3}[0-9]{3}/g;
    const regMatch = reg.match(regReq);

    const yearReq = year >= 1900 && year <= 2020;

    if (regMatch) {
        if (yearReq) {
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

/*function checkOut() {
    let currentTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
    //time function to match checkOut date format
    return currentTime;
}*/