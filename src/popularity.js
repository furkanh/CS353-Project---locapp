document.addEventListener('DOMContentLoaded', init, false);
function init(){
  var service = document.querySelector('#serviceBar');
  var ambiance = document.querySelector('#ambianceBar');
  var price = document.querySelector('#priceBar');

  service.value = 33;
  ambiance.value = 33;
  price.value = 33;
  service.addEventListener('click',function(){
    console.log(service.value);
    var val = 100 - service.value;
    var val1 = Math.floor(val/2);
    var val2 = Math.ceil(val/2);
    ambiance.value = val1;
    price.value = val2;
  });

  ambiance.addEventListener('click', function(){
    if((parseInt(ambiance.value) + parseInt(service.value)) > 100){
      ambiance.value = 100 - service.value;
    }
    price.value = 100 - (parseInt(ambiance.value) + parseInt(service.value));
  });

  price.addEventListener('click', function(){
    price.value = 100 - (parseInt(ambiance.value) + parseInt(service.value));
  });
};
