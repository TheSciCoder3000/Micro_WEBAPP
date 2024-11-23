var request = new XMLHttpRequest();

request.open('GET', "https://hplussport.com/api/products/order/name");
request.onload = function() {
    var response = request.response;
    var parsedDat = JSON.parse(response);
    console.log(parsedDat)
    parsedDat.forEach((data, indx) => {
        var descri=data.name; 
    
        var prod = document.createElement('li'); 
        prod.innerHTML = descri;
        document.body.appendChild(prod);
    
        var decrimage=data.image ; 
        var prods = document.createElement('img'); 
        prods.setAttribute('src',decrimage)
        document.body.appendChild(prods);
    });
}

request.send();
