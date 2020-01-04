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