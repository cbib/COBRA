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
// Load the fonts
Highcharts.createElement('link', {
   href: '//fonts.googleapis.com/css?family=Unica+One',
   rel: 'stylesheet',
   type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

Highcharts.theme = {
   colors: ["#2b908f", "#90ee7e", "#f45b5b", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: {
      backgroundColor: {
         linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
         stops: [
            [0, '#2a2a2b'],
            [1, '#3e3e40']
         ]
      },
      style: {
         fontFamily: "'Unica One', sans-serif"
      },
      plotBorderColor: '#606063'
   },
   title: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase',
         fontSize: '20px'
      }
   },
   subtitle: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase'
      }
   },
   xAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      title: {
         style: {
            color: '#A0A0A3'

         }
      }
   },
   yAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      tickWidth: 1,
      title: {
         style: {
            color: '#A0A0A3'
         }
      }
   },
   tooltip: {
      backgroundColor: 'rgba(0, 0, 0, 0.85)',
      style: {
         color: '#F0F0F0'
      }
   },
   plotOptions: {
      series: {
         dataLabels: {
            color: '#B0B0B3'
         },
         marker: {
            lineColor: '#333'
         }
      },
      boxplot: {
         fillColor: '#505053'
      },
      candlestick: {
         lineColor: 'white'
      },
      errorbar: {
         color: 'white'
      }
   },
   legend: {
      itemStyle: {
         color: '#E0E0E3'
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#606063'
      }
   },
   credits: {
      style: {
         color: '#666'
      }
   },
   labels: {
      style: {
         color: '#707073'
      }
   },

   drilldown: {
      activeAxisLabelStyle: {
         color: '#F0F0F3'
      },
      activeDataLabelStyle: {
         color: '#F0F0F3'
      }
   },

   navigation: {
      buttonOptions: {
         symbolStroke: '#DDDDDD',
         theme: {
            fill: '#505053'
         }
      }
   },

   // scroll charts
   rangeSelector: {
      buttonTheme: {
         fill: '#505053',
         stroke: '#000000',
         style: {
            color: '#CCC'
         },
         states: {
            hover: {
               fill: '#707073',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            },
            select: {
               fill: '#000003',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            }
         }
      },
      inputBoxBorderColor: '#505053',
      inputStyle: {
         backgroundColor: '#333',
         color: 'silver'
      },
      labelStyle: {
         color: 'silver'
      }
   },

   navigator: {
      handles: {
         backgroundColor: '#666',
         borderColor: '#AAA'
      },
      outlineColor: '#CCC',
      maskFill: 'rgba(255,255,255,0.1)',
      series: {
         color: '#7798BF',
         lineColor: '#A6C7ED'
      },
      xAxis: {
         gridLineColor: '#505053'
      }
   },

   scrollbar: {
      barBackgroundColor: '#808083',
      barBorderColor: '#808083',
      buttonArrowColor: '#CCC',
      buttonBackgroundColor: '#606063',
      buttonBorderColor: '#606063',
      rifleColor: '#FFF',
      trackBackgroundColor: '#404043',
      trackBorderColor: '#404043'
   },

   // special colors for some of the
   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
   background2: '#505053',
   dataLabelsColor: '#B0B0B3',
   textColor: '#C0C0C0',
   contrastTextColor: '#F0F0F3',
   maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);

function show_heatmap(element){
    clicked_id = element.getAttribute('data-id');
    var x_array = element.getAttribute('data-x');
    var series_array = element.getAttribute('data-series');
    //var dpi=element.getAttribute('data-dpi');
    day = new Array(series_array);
    //alert(clicked_id);
    $('#test_'+clicked_id).highcharts({

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
            categories: JSON.parse(x_array),
            labels: {
                enabled: false
            }

        },
        

        yAxis: {
            categories: ['21 dpi'],
            title: null
        },

        colorAxis: {
            stops: [
                [0, '#3060cf'],
                [0.3, '#fffbbc'],
                [0.7, '#c4463a'],
                [1, '#c4463a']
            ],
            min: -4,
            max:4,
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
            data: JSON.parse(day)
            
        }]

    });

}




//	$(document).ready(function() {
//        $("#blast_button").click(function(){
//                $.ajax({
//                    url : './tools/blast/blast.php', // La ressource ciblée
//                    type : 'POST' ,// Le type de la requête HTTP.
//                    data : 'search=' + genes + '&sequence=' + sequence,
//                    dataType : 'html',
//                    success:function(myoutput){                   
//                        $(":hidden").val(myoutput.srno);
//                        if(myoutput.flag=="1")
//                        {                                       
//                            window.location="chat.php";
//                        }
//                        else
//                        {
//                            $("#msg").html("Invalid Login");
//                        }
//                    }
//                });
//          });
//    });
        
    //var button_clicked = document.getElementById("blast_button");
//    var button_clicked=document.getElementById('blast_button').onclick();
    
    //alert(clicked_transcript_id);

	
    
    //$(this).attr('trancript_sequence_fasta').children();
//    function loader(){
//        $('#blast_button').click(function() {
//                //alert(clicked_transcript_id);
//                //var seq= $(this).getAttribute("data-sequence");
//                var target = $(this).attr('data-id');
//                alert(target);
//				$.ajax({
//                    
//					 url : './tools/blast/blast.php', // La ressource ciblée
//
//                    type : 'POST' ,// Le type de la requête HTTP.
//
//                    //data : 'search=' + genes + '&sequence=' + clicked_sequence,
//                    data : 'search=' + clicked_transcript_id + '&species=' + species,
//
//                   
//                    method: 'post',
//					cache: false,
//					async: true,
//					dataType: "html",
//					success: function (data) {
//						//alert(data);
//                        var jqObj = jQuery(data);
//                        var par=jqObj.find("#blast_results");
//                        
//                        $(".content_test_"+clicked_transcript_id ).empty().append(par);
//                        
//                        //works to load results in element
////                        $( ".content_test" ).load( "tools/blast/blast.php #paragraph",{
////                            search : genes,
////
////                            sequence : sequence
////                            
////                        } );
//                        
//                        
//                        
//                        //$( ".loading" ).load( "tools/blast/blast.php #paragraph" );
//						//$('.content_test').empty().html(data);
//					}
//				});
//        });
//    }
   
   
 
//    $(document).ready(function(){
//        //loader();
//        $('#blast_button').click(function() {
//                //alert(clicked_transcript_id);
//                //var seq= $(this).getAttribute("data-sequence");
//                var target = $(this).attr('data-id');
//                //alert(target);
//				$.ajax({
//                    
//					 url : './tools/blast/blast.php', // La ressource ciblée
//
//                    type : 'POST' ,// Le type de la requête HTTP.
//
//                    //data : 'search=' + genes + '&sequence=' + clicked_sequence,
//                    data : 'search=' + clicked_transcript_id + '&species=' + species,
//
//                   
//                    method: 'post',
//					cache: false,
//					async: true,
//					dataType: "html",
//					success: function (data) {
//						//alert(data);
//                        var jqObj = jQuery(data);
//                        var par=jqObj.find("#blast_results");
//                        
//                        $(".content_test_"+clicked_transcript_id ).empty().append(par);
//                        
//                        //works to load results in element
////                        $( ".content_test" ).load( "tools/blast/blast.php #paragraph",{
////                            search : genes,
////
////                            sequence : sequence
////                            
////                        } );
//                        
//                        
//                        
//                        //$( ".loading" ).load( "tools/blast/blast.php #paragraph" );
//						//$('.content_test').empty().html(data);
//					}
//				});
//        });
//    });

//    $(document).ready(function() {
//        $('#trancript_sequence_fasta').on('click button', function(event) {
//            var $target = $(event.target),
//                itemId = $target.data('id');
//                alert(itemId);
//
//            //do something with itemId
//        });
//    });
   
   
//$(document).on({
//    ajaxStart: function() { 
//                //$(".content_test_"+clicked_transcript_id).fadeOut("slow");
//                $(".content_test_"+clicked_transcript_id).hide();
//                $('.loading_'+clicked_transcript_id).html("<img src='../images/ajax-loader.gif' />");
//
//                $(".loading_"+clicked_transcript_id).show();
//
//    },
////        ajaxStop: function() {
////                    setTimeout(function() { 
////                    $(".loading").fadeOut("slow");
////                    $(".content_test").show("slow");
////                    
////                  }, 5000);                                        
////        }, 
//    ajaxComplete: function() {
//
//                $(".loading_"+clicked_transcript_id).fadeOut("slow");
//                $(".content_test_"+clicked_transcript_id).show("slow");
//
//    }    
//});
   
   
 function show_profiles(element){

    var id= element.attr('data-id');
    var species=element.attr('data-species');
    var categories=element.attr('data-categories');
    var series=element.attr('data-series');
    series_array = new Array(series);
    $('#container_profile').highcharts({
        //alert ($(this).attr('data-alias'));
        chart: {
            type: 'column'
        },
        title: {
            text: id + ' differential expression ('+species+')' 
        },
//            subtitle: {
//                text: xp_name
//            },
        xAxis: {

            categories: JSON.parse(categories),
            //categories: <?php echo json_encode($expression_data_array[0]); ?>

            //categories: ['Apples', 'Oranges', 'Oranges', 'Oranges', 'Oranges', 'Pears', 'Grapes', 'Bananas']

            //title: {text: 'Samples'}
        },
        yAxis: {

            title: {
                text: 'Log FC'
            }

        },
//            yAxis: {
//                //type: 'logarithmic'
//                title: 'Log FC'
//            },
        series: JSON.parse(series_array),
        //series: <?php echo json_encode($expression_data_array[1]); ?>,
        tooltip: {
            useHTML: true,
            formatter: function(genes) {
            //for series 
            //+this.series.name+ xp name
                var s = '';

                var g=genes;
                //window.alert(genes);

                var x_name=this.point.xp_name;
                var clean_xp_name=x_name.replace(/\\s/g, " ");

                //echo './description/experiments.php?xp='.str_replace(' ','\s',$xp_name[0]);
                //http://127.0.0.1/src/description/experiments.php?xp=Transcriptionnal\sresponse\sto\spotyviruses\sinfection\sin\sArabidopsis\sPart\s3
                s += '<ul><li style="font-size:10px";><a target="_blank" href="./description/experiments.php?xp='+ x_name +'">'+clean_xp_name+'</a></li><li style="font-size:10px";>'+'profile on Day '+ this.point.dpi +' post inoculation</li><li style="font-size:10px";>Variety : '+ this.point.variety +'</li><li style="font-size:10px";>infection agent : '+ this.point.infection_agent +'</li><li style="font-size:10px";>infection type 1 : '+ this.point.first_condition +'</li><li style="font-size:10px";>infection type 2 : '+ this.point.second_condition +'</li><li style="font-size:10px";>logFC : '+ this.point.logFC +'</li></br>'
                     '</ul>';

                return s;
            }
        }
        //if (typeof variable === 'undefined' || variable === null) {}


          //series: serie

    });
 };
    //highcharts container

//pyramid container
//$(function () {
//
//    $('#container_pyramid').highcharts({
//        chart: {
//            type: 'pyramid',
//            marginRight: 100
//        },
//        title: {
//            text: '',
//            x: -50
//        },
//        plotOptions: {
//            series: {
//                dataLabels: {
//                    enabled: true,
//                    format: '<b>{point.name}</b> ({point.y:,.0f})',
//                    color: 'black',
//                    softConnector: true
//                }
//            }
//        },
//        legend: {
//            enabled: false
//        },
//        series: [{
//            name: 'Unique users',
//            data: [
//                ['Expression Score', <?php echo(json_encode($score_exp)); ?>],
//                ['Interaction Score', <?php echo(json_encode($score_int)); ?>],
//                ['Orthology Score', <?php echo(json_encode($score_ort)); ?>],
//                ['QTL Score', <?php echo(json_encode($score_QTL)); ?>],
//                ['SNP Score', <?php echo(json_encode($score_SNP)); ?>]
//            ]
//        }]
//    });
//});
  

//            dataLabels: {
//                //enabled: true,
//                color: '#000000'
//            }

//pie container

//$(function () {
//
//    $('#container_pie').highcharts({
//        chart: {
//            plotBackgroundColor: null,
//            plotBorderWidth: null,
//            plotShadow: false,
//            type: 'pie'
//        },
//        title: {
//            text: ''
//        },
//        tooltip: {
//            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
//        },
//        plotOptions: {
//            pie: {
//                allowPointSelect: true,
//                cursor: 'pointer',
//                dataLabels: {
//                    enabled: false
//                },
//                showInLegend: true
//            }
//        },
//        series: [{
//            name: 'Score: '+<?php echo(json_encode(max($percent_array))); ?>,
//            colorByPoint: true,
//            data: [{
//                name: 'Expression Score',
//
//                y: <?php echo(json_encode($percent_exp)); ?>
//            }, {
//                name: 'Interaction Score',
//
//                y: <?php echo(json_encode($percent_int)); ?>,
//
//                sliced: true,
//                selected: true
//            }, {
//                name: 'Orthology Score',
//                y: <?php echo(json_encode($percent_ort)); ?>
//
//            }, {
//                name: 'QTL Score',
//                y: <?php echo(json_encode($percent_QTL)); ?>
//
//            }, {
//                name: 'Genetic Markers Score',
//                y: <?php echo(json_encode($percent_SNP)); ?>
//
//            }]
//
//        }]
//    });
//});
//chart container
//$(function () {
//    $('#container_chart').highcharts({
//        chart: {
//            type: 'bar'
//        },
//        title: {
//            text: 'Stacked bar chart'
//        },
//        xAxis: {
//            categories: ['Global Score']
//        },
//        yAxis: {
//            min: 0,
//            title: {
//                text: 'Total Score'
//            }
//        },
//        legend: {
//            reversed: true
//        },
//        plotOptions: {
//            series: {
//                stacking: 'normal'
//            }
//        },
//        series: [{
//            name: 'Transcriptomics',
//            data: [<?php echo(json_encode($score_exp)); ?>]
//        }, {
//            name: 'Interactomics',
//            data: [<?php echo(json_encode($score_int)); ?>]
//        },{
//            name: 'orthology',
//            data: [<?php echo(json_encode($score_ort)); ?>]
//        },{
//            name: 'genetics',
//            data: [<?php echo(json_encode($score_QTL)); ?>]
//        }, {
//            name: 'Polymorphism',
//            data: [<?php echo(json_encode($score_SNP)); ?>]
//        }]
//    });
//});



