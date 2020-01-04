function addCustomerCtrl() {
    let pn = document.querySelector("#personnummer").value;
    let tel = document.querySelector("#telefonnummer").value;

    let pnReq = /[0-9]{2}(?:0[1-9]|1[12])[0-3][0-9][0-9]{4}/g;
    let pnMatch = pn.match(pnReq);

    let teleReq = /^0/g;
    let teleMatch = tel.match(teleReq);

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

