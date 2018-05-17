
var $ = require('jquery');

document.addEventListener('DOMContentLoaded', function() {
  var skillName = document.querySelectorAll('.skill-name');

  var isName = [];
  for (var i = 0; i < skillName.length; i++) {
    isName.push(skillName[i].dataset.isNamed);
  }

  var skillScore = document.querySelectorAll('.skill-score');
  var isScore = [];
  for (var i = 0; i < skillScore.length; i++) {
    isScore.push(skillScore[i].dataset.isScored);
  }
  var score = isScore.map(Number);

  var Chart = require('chart.js');

  var ctx = document.getElementsByClassName("myChart");

  console.log(ctx.length);

  for (i = 0; i < ctx.length; i++) {

    var myChart = new Chart(ctx[i], {
      type: 'bar',
      data: {
        labels: isName,
        // labels: ['Blue', 'Red'],
        datasets: [{
          label: '# of Votes',
          // data: [12, 19, 3, 5, 2, 3],
          data: score,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true
            }
          }]
        }
      }
    });

  }
});

$(document).ready(function(){

  $(".btn-hide").click(function(){
    $(".have-children > ul").slideUp();
  });
  $(".btn-show").click(function(){
    $(".have-children > ul").slideDown();
  });
});