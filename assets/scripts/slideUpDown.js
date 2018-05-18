
var $ = require('jquery');

$(document).ready(function(){

  $(".btn-hide").click(function(){
    $(".have-children > ul").slideUp();
  });
  $(".btn-show").click(function(){
    $(".have-children > ul").slideDown();
  });
});