function calcTotal() {

}

function updateCart(num, bookid, customercode) {
    var cart = num;
    var b_code = bookid;
    var qty = document.getElementById(b_code);
    var c_code = customercode;
    location.href = 'updateCart.php?cart=' + cart + '&qty=' + qty + '&b_code=' + b_code + '&c_code=' + c_code;
}