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

   $(function (element){
    clicked_id = element.getAttribute('data-id');
    //var x_array = element.getAttribute('data-x');
    //var x_array=element.attr('data-x');
    //var series_array = element.attr('data-series');
    //var series_array = element.getAttribute('data-series');
    //var dpi=element.getAttribute('data-dpi');
    //day = new Array(series_array);


    $('.container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Monthly Average Rainfall'
        },
        subtitle: {
            text: 'Source: WorldClimate.com'
        },
        xAxis: {
            categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Rainfall (mm)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Tokyo',
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

        }, {
            name: 'New York',
            data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

        }, {
            name: 'London',
            data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

        }, {
            name: 'Berlin',
            data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

        }]
    });
}); 

$(document).on({
    ajaxStart: function() { 
                //$(".content_test_"+clicked_transcript_id).fadeOut("slow");
                $(".test_"+clicked_id).hide();
                $('.loading_'+clicked_id).html("<img src='../../images/ajax-loader.gif' />");

                $(".loading_"+clicked_id).show();

    },

    ajaxComplete: function() {

                $(".loading_"+clicked_id).fadeOut("slow");
                $(".test_"+clicked_id).show("slow");
                

    }    
});
//            dataLabels: {
//                //enabled: true,
//                color: '#000000'
//            }



