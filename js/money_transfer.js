function loadDoc(id = -1) {
    let xhttp = new XMLHttpRequest();
    let url = "./blocks/transaction_table.php";
    let params;

    if(id === -1) {
        const ACCOUNT_ID = document.getElementById('account-id');
        if(ACCOUNT_ID.value == -1) return;
        params = 'account-id=' + ACCOUNT_ID.value;
    }
    else {
        params = 'account-id=' + id;
    }

    xhttp.open("POST", url, true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("table-container").innerHTML = this.responseText;
        }
    };
    xhttp.send(params);
}