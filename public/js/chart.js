var ctx = document.getElementById("myChart").getContext('2d');

window.addEventListener('load', drawChart());

// 201007↓作業途中　これをonloadイベントにセット
function drawChart( myChart ){
    var container = $('.canvas-container');
    var ctx = $('#myChart');
    // ctx.attr('width', container.width());   
    if(myChart != null && myChart != undefined){
        myChart['options']['scales']['xAxes'] = [{gridLines: {display: false}}];
    }
    // ctx.attr('width', container.width());
    ctx.attr('height', 400);    
    var myChart = new Chart(ctx, myChart);
}


// 201007　↓のjsonをcontroller側で生成しようとしている

// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ["赤", "青", "黄色", "緑", "紫", "橙"],
//         datasets: [{
//             label: '得票数',
//             data: [12, 19, 3, 5, 2, 3],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255,99,132,1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero:true
//                 }
//             }]
//         }
//     }
// });

