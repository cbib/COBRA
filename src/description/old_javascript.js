/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(
function() {
	$('#example').dataTable( {
		"scrollX": true,
		"jQueryUI": true,
		"pagingType": "full_numbers",
		"oLanguage": { 
			"sProcessing":   "Processing...",
			"sLengthMenu":   "display _MENU_ items",
			"sZeroRecords":  "No item found",
			"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
			"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
			"sInfoFiltered": "(filtered from _MAX_ items in total)",
			"sInfoPostFix":  "",
			"sSearch":       "Search: ",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "First",
				"sPrevious": "Previous",
				"sNext":     "Next",
				"sLast":     "Last"
			}
		},
		"language": {
            		"decimal": ",",
            		"thousands": "."
        }
	});
});

$(function () {

    $('#container').highcharts({

        chart: {
            type: 'heatmap',
            marginTop: 40,
            marginBottom: 80,
            plotBorderWidth: 1
        },


        title: {
            text: 'Differentially expressed genes'
        },

        xAxis: {
            categories: "<?php echo json_encode($x_categories); ?>",
            labels: {
                enabled: false
            },

/*            categories: ['ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100'],*/

        },
        

        yAxis: {
            categories: ['21dpi'],
            title: null
        },

        colorAxis: {
            stops: [
                [0, '#3060cf'],
                [0.2, '#fffbbc'],
                [0.8, '#c4463a'],
                [1, '#c4463a']
            ],
            min: -5,
            max:5,
            minColor: '#FFFFFF',
            maxColor: Highcharts.getOptions().colors[0]
        },
        plotOptions: {
            series: {
                events: {
                    click: function (event) {
                        //alert(event.point.series.xAxis.categories[event.point.x] );
                        window.location.href = "../Multi-results.php?organism=All+species&search=" +event.point.series.xAxis.categories[event.point.x];
                    }
                }
            }
        },
        legend: {
            align: 'right',
            layout: 'vertical',
            margin: 0,
            verticalAlign: 'top',
            y: 25,
            symbolHeight: 280
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.series.xAxis.categories[this.point.x] + '</b> log fold change equals to <br><b>' +
                    this.point.value + '</b> on <br><b>' + this.series.yAxis.categories[this.point.y] + '</b>';
            }
        },

        series: [{
            name: 'Differentially expressed genes (logFC > 2 or logFC < -2)',
            borderWidth: 1,
            data: "<?php echo json_encode($y_categories); ?>",
        }]

    });
});

            
//            dataLabels: {
//                //enabled: true,
//                color: '#000000'
//            }



