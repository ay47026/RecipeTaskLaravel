const { fromPairs } = require('lodash');

require('./bootstrap');


$(".export").on('click',function(){
  let dataurl =  $(this).attr("data_url");
  window.location.href = dataurl;
});

function listing(){
  let baseurl = $('.baseurl').attr("baseurl");
console.log(baseurl);
let request = $.ajax({
  url: baseurl,
  type: "GET"
});

request.done(function(res) {
  res.forEach(element => {
    let dd = "<tr><td>" + element.recipe_name +"</td><td>" + element.category_id +"</td><td>" + element.range_to +"</td><td>" + element.range_from +"</td></tr>";
    let listing = $(".listing").append(dd);
  });
});

request.fail(function(jqXHR, textStatus) {
  alert( "Request failed: " + textStatus );
});

}
listing();

$(document).ready(function() {
  $('.myform').on('submit', function(e){
    e.preventDefault();
    let url = $(this).attr('action');
    let method = $(this).attr('method');
    let data = $(this).serialize();
    let dataarray =  $(this).serializeArray();
       dataarray.forEach(element => {
      console.log(element.range_from);
    });
    console.log(data);
    let request = $.ajax({
      url: url,
      type: method,
      data: data,
 
    });

    request.done(function(res) {

      $(".msg").html( res );
      listing();
     
    });

    request.fail(function(jqXHR, textStatus) {
      alert( "Request failed: " + textStatus );
    });




    
  
  });
});