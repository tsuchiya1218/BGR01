function calcTotal(e) {
    var i, //個数
        price = 0, //項目毎の金額
        amount = 0; //合計金額
    for (s = 0; s < document.receiving.length-1;s++) {
        if(document.receiving.elements[s].checked){
            i = document.getElementById(qty);
            amount += eval(document.receiving.elements[s])*i;
        }
        document.receiving.total.value = amount;
    }
}