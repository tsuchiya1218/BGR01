//カウンター
let counter = document.getElementsByClassName("counter");
//加算
function addOne(cnt){
	let counter = document.getElementsByClassName("counter").item(cnt);
    counter.value = Number(counter.value) + 1;
}

//減算
function subOne(cnt){
	let counter = document.getElementsByClassName("counter").item(cnt);
    if(counter.value>0){
        counter.value = Number(counter.value) - 1;
    }
}

function calcTotal(){
    var price = document.getElementById('check').value;
    var amount = document.getElementById('amount');
    price.addEventListener('click',function(){
        amount.value += price ;
    })
}