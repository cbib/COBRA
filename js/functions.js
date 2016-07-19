
//Global variable
var profile_already_open="false";
var genetic_marker_already_open="false";
var genetic_qtl_already_open="false";
var pv_already_open="false";
var pp_already_open="false";
var orthologs_already_open="false";
var transcripts_already_open="false";
var unspliced_already_open="false";
var top_scored_gene_open="false";

var detailData=[];
var chaine="";


//show heatmap for expression profile
function show_heatmap(element,clicked_id,FCmin, FCmax,species){
    //var clicked_id = element.getAttribute('data-id');
    //var x_array = element.getAttribute('data-x');
    var x_array=element.attr('data-x');
    var total_diff_gene=element.attr('data-total-diff');
    var total_gene=element.attr('data-total');
    
    
    var series_array = element.attr('data-series');
    //var series_array = element.getAttribute('data-series');
    dpi=element.attr('data-dpi');
    day = new Array(series_array);
    //alert(clicked_id);
    $('.heatmap_'+clicked_id).highcharts({
        
//        exporting: {
//            buttons: {
//                customButton: {
//                    text: 'Custom Button',
//                    align: 'right',
//
//                    onclick: function () {
//                        alert('You pressed the button!');
//                    }
//                },
//               anotherButton: {
//                    text: 'Another Button',
//                    text: 'Custom Button',
//                    align: 'right',
//
//                    onclick: function () {
//                        alert('You pressed another button!');
//                    }
//                }
//            }
//        },
        chart: {
            type: 'heatmap',
            marginTop: 40,
            marginBottom: 130,
            
            
            plotBorderWidth: 1,
            events: {
                    load: function () {
                        //var label = this.renderer.label("set of differentially expressed genes (logFC \> "+max+" and \&lt; "+min+" n= "+total_diff_gene+") is compared to terms of all micro array genes(n= "+total_gene+", green bars). The y-axis displays the fraction relative to all GO Molecular Function terms. These terms do not show a significant enrichment (p>0.5).")

                        var label = this.renderer.label("set of differentially expressed genes (n= "+total_diff_gene+") with logFC \> "+FCmax+" and \&lt; "+FCmin)
                        .css({
                            width: '850px',
                            color: '#222',
                            fontSize: '16px'
                        })
                        .attr({
                            'stroke': 'silver',
                            'stroke-width': 2,
                            'r': 5,
                            'padding': 10
                        })
                        .add();
                
                        label.align(Highcharts.extend(label.getBBox(), {
                            align: 'center',
                            x: 0, // offset
                            verticalAlign: 'bottom',
                            y: 5 // offset
                        }), null, 'spacingBox');
                
                    }//,
//                    selection: function(event) {
////                        if (event.xAxis) {
////                            //event.point.series.xAxis.categories[event.point.x]
////                            //alert(this.series.categories);
//                                //console.log(event.xAxis[0]);
//                                var extremesObject = event.xAxis[0];
//                                min = extremesObject.min;
//                                max = extremesObject.max;
//                                chaine="";
//                                
//                                xAxis = this.xAxis[0];
//                                //console.log(xAxis.categories);
//                                // reverse engineer the last part of the data
//                                
//                                //this.series.xAxis.categories[this.point.x]
//                                $.each(this.series[0].data, function () {
//                                    if (this.x > min && this.x < max) {
//                                        
//                                        
//                                        detailData.push([this.x, this.y,xAxis.categories[parseInt(this.x)]]);
//                                        chaine = chaine+xAxis.categories[parseInt(this.x)]+"+";
//                                    }
//                                });
//                                //console.log(detailData);
//                                test=chaine.slice(0, chaine.length-1);
//                                console.log(test);
//                                
////                            //alert('min: '+ event.xAxis +', max: '+ event.xAxis[0].max);
////                            //alert('min: '+ event.point.series.xAxis.categories[event.point.x] +', max: '+ event.xAxis[0].max);
////                        } else {
////                            $alert('Selection reset');
////                        }
//                    }
            },
            zoomType: 'x'
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
            categories: [dpi+' dpi'],
            title: null
        },

        colorAxis: {
            stops: [
                [0, '#3060cf'],
                [0.35, '#A9E2F3'],
                [0.5, '#fffbbc'],
                [0.65, '#FE9A2E'],
                //[0.75, '#c4463a'],
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
                        //window.location.href = "../Multi-results.php?organism=All+species&search=" +event.point.series.xAxis.categories[event.point.x];
                        window.open("../Multi-results.php?organism=All+species&search=" +event.point.series.xAxis.categories[event.point.x]);

                   }
//                   ,                    ,
//                    select: function () {
//                            console.log(this.category + ': ' + this.y + ' was last selected');
//                    }
                    
                    
                    
                }
//                ,
//                allowPointSelect: true,
//                point: {
//                    events: {
//                        select: function () {
//                            console.log(this.category + ': ' + this.y + ' was last selected');
//                        }
//                    }
//                }
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
                return '<b>' + this.series.xAxis.categories[this.point.x] + '</b><br>Log fold change: <b>' +
                    this.point.value + '</b><br>Day post inoculation: <b>' + this.series.yAxis.categories[this.point.y] + '</b>';
            }
        },

        series: [{
            name: 'Differentially expressed genes (logFC > 2 or logFC < -2)',
            borderWidth: 1,
            data: JSON.parse(day)
            
        }], 
        exporting: {
            buttons: {
                customButton: {
                    text: 'Search on selected genes',
                    onclick: function () {
                        //xAxis = this.xAxis[0];
                        //alert(xAxis.categories) 
                        //var test=xAxis.categories
                        //res = test.replace(",", "+"); 
                        
                        //alert(res)
                        var extremesObject = this.xAxis[0];
                        min = extremesObject.min;
                        max = extremesObject.max;

                        xAxis = this.xAxis[0];
                        //console.log(xAxis.categories);
                        // reverse engineer the last part of the data

                        //this.series.xAxis.categories[this.point.x]
                        $.each(this.series[0].data, function () {
                            if (this.x > min && this.x < max) {
                                
                                chaine = chaine+xAxis.categories[parseInt(this.x)]+"+";
                                


                                detailData.push([this.x, this.y,xAxis.categories[parseInt(this.x)]]);
                            }
                        });
                        
                        //console.log(detailData);
                        test=chaine.slice(0, chaine.length-1);
                        //console.log(test);
                        console.log("../Multi-results.php?organism=All+species&search="+test);
                        //window.open("../Multi-results.php?organism=All+species&search="+test);
                        window.open("../Multi-results.php?organism="+species+"&search="+test);
                      
                        
                        
                        
                        
                        
                        //document.location.href="../Multi-results.php?organism=All+species&search=AT1G75950+ATCG01100
                        
                        
                        //alert('You pressed the button!');
                    }
                }
            }
        }
    });
//    $('#add').click(function() {
//        var chart = $('.heatmap_'+clicked_id).highcharts();
//        normalState = new Object();
//        normalState.stroke_width = null;
//        normalState.stroke = null;
//        normalState.fill = null;
//        normalState.padding = null;
//        normalState.r = null;
//
//        hoverState = new Object();
//        hoverState = normalState;
//        hoverState.fill = 'red';
//        
//        pressedState = new Object();
//        pressedState = normalState;
//        
//        var custombutton = chart.renderer.button('button', 74, 10, function(){
//            alert('New Button Pressed');
//        },null,hoverState,pressedState).add();
//    });

}
//AJAX function for GO enrichment 
function load_heatmap(element){
    //alert(element.getAttribute('data-id')) ;
    //clicked_transcript_id = element.getAttribute('data-id');
    clicked_id = element.getAttribute('data-id');
    logFCmin = element.getAttribute('data-min');
    logFCmax = element.getAttribute('data-max');
    species=element.getAttribute('data-species');
    
    $.ajax({

        url : './load_profile.php', // La ressource ciblée
        type : 'POST' ,// Le type de la requête HTTP.
        data : 'search=' + clicked_id + '&min=' + logFCmin + '&max=' + logFCmax,

        method: 'post',
        cache: false,
        async: true,
        dataType: "html",
        beforeSend: function() { 
           	    //  alert("start");
				$(".test_"+clicked_id).hide();
                $('.loading_'+clicked_id).html("<img src='../../images/ajax-loader.gif' />");

                $(".loading_"+clicked_id).show();
			},
        success: function (data) {
            //alert(data);
            var jqObj = jQuery(data);
            //alert(clicked_id);
            var par=jqObj.find(".heatmap_"+clicked_id);
            //alert(par)
            
            
            $(".test_"+clicked_id).empty().append(par);
            //alert("div has been append");
            show_heatmap(par,clicked_id,logFCmin,logFCmax,species);
        },
        complete:function(){  
            //   alert("stop");
            $(".loading_"+clicked_id).fadeOut("slow");
            $(".test_"+clicked_id).show("slow");
	}
    });

}
//set value for min logFC
function change_min_logFC(element){
    clicked_id = element.getAttribute('data-id');
    
    new_min_logFC = element.options[element.selectedIndex].value;

    //var element_to_modify = document.getElementById("GO_button_"+clicked_id); 
    //element_to_modify.setAttribute("data-min", new_min_logFC);
    //var element_to_modify = document.getElementById("heatmap_button_"+clicked_id); 
    //element_to_modify.setAttribute("data-min", new_min_logFC);
    
    $(".heatmap_button_"+clicked_id).attr("data-min", new_min_logFC);
    $(".GO_button_"+clicked_id).attr("data-min", new_min_logFC);
    
    
}
//set value for max logFC
function change_max_logFC(element){
    clicked_id = element.getAttribute('data-id');
    new_max_logFC = element.options[element.selectedIndex].value;
    //var element_to_modify = document.getElementById("heatmap_button_"+clicked_id); 
    //element_to_modify.setAttribute("data-max", new_max_logFC);
    $(".heatmap_button_"+clicked_id).attr('data-max', new_max_logFC);
    $(".GO_button_"+clicked_id).attr('data-max', new_max_logFC);

    
    
    
    //var element_to_modify = document.getElementById("GO_button_"+clicked_id); 
    //element_to_modify.setAttribute("data-max", new_max_logFC);

}
//show highcharts for GO enrichment
function show_GO_enrichment(element,clicked_id){
    var x_array=element.attr('data-x');
    var series_array = element.attr('data-series');
    
  
    //alert(datas);
    //var x_array = element.getAttribute('data-x');
    //var x_array=element.attr('data-x');
    //var series_array = element.attr('data-series');
    //var series_array = element.getAttribute('data-series');
    //var dpi=element.getAttribute('data-dpi');
    //datas = new Array(series_array);


    $('.GO_'+clicked_id).highcharts({
        chart: {
            type: 'column'
            //marginTop: 40,
            //marginBottom: 130,
            
        },
        
        title: {
            text: 'Enrichment for GO main terms of genes differentially expressed.  '
        },
        subtitle: {
            text: 'Source: WorldClimate.com'
        },
        xAxis: {
            categories:  JSON.parse(x_array),
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
        series: JSON.parse(series_array)
    });
};

function load_GO_enrichment(element){
    //alert(element.getAttribute('data-id')) ;
    //clicked_transcript_id = element.getAttribute('data-id');
    
    clicked_id = element.getAttribute('data-id');
    logFCmin = element.getAttribute('data-min');
    logFCmax = element.getAttribute('data-max');
    species = element.getAttribute('data-species');

  
    $.ajax({

        url : './GO_enrichment_search.php', // La ressource ciblée
        type : 'POST' ,// Le type de la requête HTTP.
        data : 'xp_id=' + clicked_id + '&min=' + logFCmin + '&max=' + logFCmax + '&species=' + species,
        
        method: 'post',
        cache: false,
        async: true,
        dataType: "html",
        beforeSend: function() { 
           	    //  alert("start");
				$(".GOtest_"+clicked_id).hide();
                $('.GOloading_'+clicked_id).html("<img src='../../images/ajax-loader.gif' />");

                $(".GOloading_"+clicked_id).show();
		},
        success: function (data) {
            //alert(data);
            var jqObj = jQuery(data);
            //alert(clicked_id);
            //var par=jqObj.find(".GO_"+clicked_id);
            var par=jqObj.find("#testTable");
            //
            //
//alert(par.attr('data-x'));
            //alert(par.attr('data-series'));
            
            
            $(".GOtest_"+clicked_id).empty().append(par);
            //alert("div has been append");
            //show_GO_enrichment(par,clicked_id);
        },
        complete:function(){  
            //   alert("stop");
            $(".GOloading_"+clicked_id).fadeOut("slow");
            $(".GOtest_"+clicked_id).show("slow");
            //$(".GOparagraph_"+clicked_id).show("slow");
        }        
    });

}

//AJAX function for GO enrichment 
function load_GO_enrichment_old(element){
    //
    
    //clicked_transcript_id = element.getAttribute('data-id');
    clicked_id = element.getAttribute('data-id');
    logFCmin = element.getAttribute('data-min');
    logFCmax = element.getAttribute('data-max');
    species = element.getAttribute('data-species');

  
    $.ajax({

        url : './GO_enrichment.php', // La ressource ciblée
        type : 'POST' ,// Le type de la requête HTTP.
        data : 'xp_id=' + clicked_id + '&min=' + logFCmin + '&max=' + logFCmax + '&species=' + species,
        
        method: 'post',
        cache: false,
        async: true,
        dataType: "html",
        beforeSend: function() { 
           	    //  alert("start");
				$(".GOtest_"+clicked_id).hide();
                $('.GOloading_'+clicked_id).html("<img src='../../images/ajax-loader.gif' />");

                $(".GOloading_"+clicked_id).show();
		},
        success: function (data) {
            //alert(data);
            var jqObj = jQuery(data);
            //alert(clicked_id);
            //var par=jqObj.find(".GO_"+clicked_id);
            var par=jqObj.find(".GO_"+clicked_id);
            //
            //
//alert(par.attr('data-x'));
            //alert(par.attr('data-series'));
            
            
            $(".GOtest_"+clicked_id).empty().append(par);
            //alert("div has been append");
            show_GO_enrichment(par,clicked_id);
        },
        complete:function(){  
            //   alert("stop");
			$(".GOloading_"+clicked_id).fadeOut("slow");
            $(".GOtest_"+clicked_id).show("slow");
            $(".GOparagraph_"+clicked_id).show("slow");
		}        
    });

}

//AJAX function for top scored genes 
function load_top_scored_genes(){

   
 
    
    
    if (top_scored_gene_open==="true"){
       //alert("already open");
       //open="false";
   }
    else{
        $.ajax({

            url : '../functions/top_scored_genes_page.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            //data : 'test=' + gene_ids + '&gene_ids_bis=' + genebis_ids +'&species=' + species+ '&mode=unspliced',


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            beforeSend: function() { 
                    //  alert("start");
                    $(".top_score_area").hide();
                    $('.TopScoredloading').html("<img src='../../images/ajax-loader.gif' />");

                    $(".TopScoredloading").show();
                },

            success: function (data) {

                var jqObj = jQuery(data);

                var par;

                if(jqObj.find("#S-genes").length){
                   par=jqObj.find("#S-genes");
                   $(".top_score_area").empty().append(par);
                   load_table(par);
                }
                else{
                   par=jqObj.find(".no_results");
                   $(".top_score_area").empty().append(par);
                
                   
                }
                
                

            },
            complete:function(){  
                //   alert("stop");
                $(".TopScoredloading").fadeOut("slow");
                $(".top_score_area").show("slow");
            }



        });
        top_scored_gene_open="true";
        }
}  
//AJAX function for plant/plant interaction 
function load_unspliced(element){
    species=element.getAttribute('data-species');
    gene_ids=element.getAttribute('data-gene');
    genebis_ids=element.getAttribute('data-genebis');
    //gene_id=element.getAttribute('data-id');
   
 
    
    
    if (unspliced_already_open==="true"){
       //alert("already open");
       //open="false";
   }
    else{
        $.ajax({

            url : './functions/sequences_page.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            data : 'gene_ids=' + gene_ids + '&gene_ids_bis=' + genebis_ids +'&species=' + species+ '&mode=unspliced',


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            beforeSend: function() { 
                    //  alert("start");
                    $(".unspliced_area").hide();
                    $('.unsplicedloading').html("<img src='../images/ajax-loader.gif' />");

                    $(".unsplicedloading").show();
                },

            success: function (data) {

                var jqObj = jQuery(data);

                var par;

                if(jqObj.find(".un_results").length){
                   par=jqObj.find(".un_results"); 
                }
                else{
                   par=jqObj.find(".no_results");
                   
                }
                
                $(".unspliced_area").empty().append(par);

            },
            complete:function(){  
                //   alert("stop");
                $(".unsplicedloading").fadeOut("slow");
                $(".unspliced_area").show("slow");
            }



        });
        unspliced_already_open="true";
        }
}  
//AJAX function for plant/plant interaction 
function load_transcripts(element){
    species=element.getAttribute('data-species');
    gene_ids=element.getAttribute('data-gene');
    genebis_ids=element.getAttribute('data-genebis');
    //gene_id=element.getAttribute('data-id');
   
 
    
    
    if (transcripts_already_open==="true"){
       //alert("already open");
       //open="false";
   }
    else{
        $.ajax({

            url : './functions/sequences_page.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            data : 'gene_ids=' + gene_ids + '&gene_ids_bis=' + genebis_ids +'&species=' + species+ '&mode=transcript',


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            beforeSend: function() { 
                    //  alert("start");
                    $(".transcript_area").hide();
                    $('.transcriptloading').html("<img src='../images/ajax-loader.gif' />");

                    $(".transcriptloading").show();
                },

            success: function (data) {

                var jqObj = jQuery(data);

                var par;

                if(jqObj.find(".tr_results").length){
                   par=jqObj.find(".tr_results"); 
                }
                else{
                   par=jqObj.find(".no_results");
                   
                }
                
                $(".transcript_area").empty().append(par);

            },
            complete:function(){  
                //   alert("stop");
                $(".transcriptloading").fadeOut("slow");
                $(".transcript_area").show("slow");
            }



        });
        transcripts_already_open="true";
        }
}
//AJAX function for plant/plant interaction 
function load_orthologs(element){
    species=element.getAttribute('data-species');
    plaza_id=element.getAttribute('data-id');
   
 
    
    
    if (orthologs_already_open==="true"){
       //alert("already open");
       //open="false";
   }
    else{
        $.ajax({

            url : './functions/orthologs_main_page.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            data : 'plaza_id=' + plaza_id + '&species=' + species,


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            beforeSend: function() { 
                    //  alert("start");
                    $(".ortholog_area").hide();
                    $('.ortloading_'+plaza_id).html("<img src='../images/ajax-loader.gif' />");

                    $(".ortloading_"+plaza_id).show();
                },

            success: function (data) {

                var jqObj = jQuery(data);

                var par;

                if(jqObj.find("#orthologs_table").length){
                   par=jqObj.find("#orthologs_table"); 
                   $(".ortholog_area").empty().append(par);
                   load_table(par);
                }
                else{
                   par=jqObj.find(".no_results");
                   $(".ortholog_area").empty().append(par);
                   
                }
                
                

            },
            complete:function(){  
                //   alert("stop");
                $(".ortloading_"+plaza_id).fadeOut("slow");
                $(".ortholog_area").show("slow");
            }



        });
        orthologs_already_open="true";
        }
}  
//AJAX function for plant/virus interaction 
function load_pv_interaction(element){
    species=element.getAttribute('data-species');
    gene_id=element.getAttribute('data-id');
    gene_ids=element.getAttribute('data-gene');
    transcript_ids=element.getAttribute('data-transcript');
    protein_ids=element.getAttribute('data-protein');
    mode=element.getAttribute('data-mode');
    
    if (pv_already_open==="true"){
       //alert("already open");
       //open="false";
   }
    else{
        $.ajax({

            url : './functions/interactions_main_page.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            data : 'gene_ids=' + gene_ids + '&transcript_ids=' + transcript_ids +'&protein_ids=' + protein_ids +'&species=' + species+'&mode=' + mode,


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            beforeSend: function() { 
                    //  alert("start");
                    $(".pv_interaction_area").hide();
                    $('.PVloading_'+gene_id).html("<img src='../images/ajax-loader.gif' />");

                    $(".PVloading_"+gene_id).show();
                },

            success: function (data) {

                var jqObj = jQuery(data);

                var par;

                if(jqObj.find(".PV").length){
                   
                   par=jqObj.find(".PV"); 
                   $(".pv_interaction_area").empty().append(par);
                   table=$(".pv_interaction").find("table");
                   
                   load_table(table);
                }
                else{
                   par=jqObj.find(".no_results");
                   $(".pv_interaction_area").empty().append(par);
                   
                }
                
                

            },
            complete:function(){  
                //   alert("stop");
                $(".PVloading_"+gene_id).fadeOut("slow");
                $(".pv_interaction_area").show("slow");
            }



        });
        pv_already_open="true";
        }
}  
//AJAX function for plant/plant interaction 
function load_pp_interaction(element){
    species=element.getAttribute('data-species');
    gene_id=element.getAttribute('data-id');
    
    gene_ids=element.getAttribute('data-gene');
    transcript_ids=element.getAttribute('data-transcript');
    protein_ids=element.getAttribute('data-protein');

    mode=element.getAttribute('data-mode');
    
    
    if (pp_already_open==="true"){
       //alert("already open");
       //open="false";
   }
    else{
        $.ajax({

            url : './functions/interactions_main_page.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            data : 'gene_ids=' + gene_ids + '&transcript_ids=' + transcript_ids +'&protein_ids=' + protein_ids +'&species=' + species+'&mode=' + mode,


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            beforeSend: function() { 
                    //  alert("start");
                    $(".pp_interaction_area").hide();
                    $('.PPloading_'+gene_id).html("<img src='../images/ajax-loader.gif' />");

                    $(".PPloading_"+gene_id).show();
                },

            success: function (data) {

                var jqObj = jQuery(data);

                var par;

                if(jqObj.find(".PP").length){
                   par=jqObj.find(".PP"); 
                   $(".pp_interaction_area").empty().append(par);
                   table=$(".pp_interaction").find("table");
                   load_table(table);
                }
                else{
                   par=jqObj.find(".no_results");
                   $(".pp_interaction_area").empty().append(par);
                   
                }
                
                

            },
            complete:function(){  
                //   alert("stop");
                $(".PPloading_"+gene_id).fadeOut("slow");
                $(".pp_interaction_area").show("slow");
            }



        });
        pp_already_open="true";
        }
}  
//AJAX function for genetic markers 
function load_genetic_markers(element){
    species=element.getAttribute('data-species');
    gene_id=element.getAttribute('data-id');
    
    gene_ids=element.getAttribute('data-gene');
    //test=new Array(gene_ids);
    start=element.getAttribute('data-start');
    end=element.getAttribute('data-end');
    scaffold=element.getAttribute('data-scaffold');
    mode=element.getAttribute('data-mode');
    
    
    if (genetic_marker_already_open==="true"){
       //alert("already open");
       //open="false";
   }
    else{
        $.ajax({

            url : './functions/genetic_markers_main_page.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            data : 'gene_ids=' + gene_ids +'&start=' + start +'&end=' + end +'&scaffold=' + scaffold +'&species=' + species+'&mode=' + mode,


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            beforeSend: function() { 
                    //  alert("start");
                    $(".genetic_markers").hide();
                    $('.GMloading_'+gene_id).html("<img src='../images/ajax-loader.gif' />");

                    $(".GMloading_"+gene_id).show();
                },

            success: function (data) {

                var jqObj = jQuery(data);

                var par;

                if(jqObj.find("#table_markers").length){
                   par=jqObj.find("#table_markers"); 
                   $(".genetic_markers").empty().append(par);
                   load_table(par);
                }
                else{
                   par=jqObj.find(".no_results");
                   $(".genetic_markers").empty().append(par);
                
                   
                }
                
                

            },
            complete:function(){  
                //   alert("stop");
                $(".GMloading_"+gene_id).fadeOut("slow");
                $(".genetic_markers").show("slow");
            }



        });
        genetic_marker_already_open="true";
        }
}  
//AJAX function for QTLs 
function load_QTLs(element){
    species=element.getAttribute('data-species');
    gene_id=element.getAttribute('data-id');
    
    gene_ids=element.getAttribute('data-gene');
    //test=new Array(gene_ids);
    start=element.getAttribute('data-start');
    end=element.getAttribute('data-end');
    scaffold=element.getAttribute('data-scaffold');
    mode=element.getAttribute('data-mode');
    
    
    if (genetic_qtl_already_open==="true"){
       //alert("already open");
       //open="false";
   }
    else{
        $.ajax({

            url : './functions/genetic_markers_main_page.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            data : 'gene_ids=' + gene_ids +'&start=' + start +'&end=' + end +'&scaffold=' + scaffold +'&species=' + species+'&mode=' + mode,


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            beforeSend: function() { 
                    //  alert("start");
                    $(".qtls").hide();
                    $('.QTLloading_'+gene_id).html("<img src='../images/ajax-loader.gif' />");

                    $(".QTLloading_"+gene_id).show();
                },

            success: function (data) {

                var jqObj = jQuery(data);

                var par;

                if(jqObj.find("#table_qtls").length){
                   par=jqObj.find("#table_qtls"); 
                   $(".qtls").empty().append(par);
                   load_table(par);
                }
                else{
                   
                   par=jqObj.find(".no_results");
                   $(".qtls").empty().append(par);
                   
                }
                
                

            },
            complete:function(){  
                //   alert("stop");
                $(".QTLloading_"+gene_id).fadeOut("slow");
                $(".qtls").show("slow");
            }



        });
        genetic_qtl_already_open="true";
        }
}  
//expression profile container  
function show_profiles(element){

    var id= element.attr('data-id');
    var species=element.attr('data-species');
    var categories=element.attr('data-categories');
    var series=element.attr('data-series');
    //alert(series_array);
    //alert(categories);
    series_array = new Array(series);
    $('#container_profile').highcharts({
        //alert ($(this).attr('data-alias'));
        chart: {
            type: 'column'
        },
        legend: {
            itemStyle: {
                fontWeight: 'bold',
                fontSize: '10px'
            }
        },
        title: {
            text: id + ' differential expression ('+species+')' 
        },
//            subtitle: {
//                text: xp_name
//            },
        xAxis: {

            categories: JSON.parse(categories),
            labels: {
                enabled: false
            }

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
                s += '<ul><li style="font-size:10px";><a target="_blank" href="./description/experiments.php?xp='+ x_name +'">'+clean_xp_name+'</a></li><li style="font-size:10px";>'+'profile on Day '+ this.point.dpi +' post inoculation</li><li style="font-size:10px";>Variety : '+ this.point.variety +'</li><li style="font-size:10px";>infection agent : '+ this.point.infection_agent +'</li><li style="font-size:10px";>infection type 1 : '+ this.point.first_condition +'</li><li style="font-size:10px";>infection type 2 : '+ this.point.second_condition +'</li><li style="font-size:10px";>logFC : '+ this.point.logFC +'</li></br></ul>';

                return s;
            }
        }
        //if (typeof variable === 'undefined' || variable === null) {}

        
        //if (typeof va

          //series: serie

    });
};
//AJAX function for expression profiles 
function load_expression_profiles(element){
    species=element.getAttribute('data-species');
    gene_id=element.getAttribute('data-id');
    
    gene_ids=element.getAttribute('data-gene');
    //test=new Array(gene_ids);
    transcript_ids=element.getAttribute('data-transcript');
    protein_ids=element.getAttribute('data-protein');
    genebis_ids=element.getAttribute('data-genebis');
    alias_ids=element.getAttribute('data-alias');
    
    
    if (profile_already_open==="true"){
       //alert("already open");
       //open="false";
    }
    else{
        $.ajax({

            url : './functions/expression_profile_main_page.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            data : 'gene_ids=' + gene_ids + '&transcript_ids=' + transcript_ids +'&protein_ids=' + protein_ids +'&genebis_ids=' + genebis_ids +'&alias_ids=' + alias_ids +'&species=' + species,


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            beforeSend: function() { 
                    //  alert("start");
                    $(".profile").hide();
                    $('.loading_'+gene_id).html("<img src='../images/ajax-loader.gif' />");

                    $(".loading_"+gene_id).show();
            },

            success: function (data) {
                
                var jqObj = jQuery(data);

                var par;

                if(jqObj.find("#container_profile").length){
                   par=jqObj.find("#container_profile"); 
                   $(".profile").empty().append(par);
                   show_profiles(par);
                }
                else{
                   
                   par=jqObj.find(".no_results");
                   $(".profile").empty().append(par);
                   
                }

  
            },
            complete:function(){  
                //   alert("stop");
                $(".loading_"+gene_id).fadeOut("slow");
                $(".profile").show("slow");
            }



        });
    profile_already_open="true";
    }
}; 
//AJAX function for Blast jobs 
function runBlast(element){

    clicked_transcript_id = element.getAttribute('data-id');
    species = element.getAttribute('data-species');


    $.ajax({

        url : './tools/blast/blast.php',
        type : 'POST' ,
        data : 'search=' + clicked_transcript_id + '&species=' + species,


        method: 'post',
        cache: false,
        async: true,
        dataType: "html",
        
        
        beforeSend: function() { 
            
            $(".content_test_"+clicked_transcript_id).hide();
            $('.loading_'+clicked_transcript_id).html("<img src='../images/ajax-loader.gif' />");
            $(".loading_"+clicked_transcript_id).show();
	},
        
        success: function (data) {

            var jqObj = jQuery(data);
            var par=jqObj.find("#blast_results");
            $(".content_test_"+clicked_transcript_id ).empty().append(par);

        },
        complete:function(){  

            $(".loading_"+clicked_transcript_id).fadeOut("slow");
            $(".content_test_"+clicked_transcript_id).show("slow");
	}
    });

}
//Highchart pie container
$(function () {

//    exp=$('#container_pie').attr('data-exp');
//    int=$('#container_pie').attr('data-int');
//    ort=$('#container_pie').attr('data-ort');
//    QTL=$('#container_pie').attr('data-QTL');
//    SNP=$('#container_pie').attr('data-SNP');

    
    try {
        exp_json=JSON.parse($('#container_pie').attr('data-exp'));                   
    } 
    catch (e) {
        exp_json=0;
    }
    try {
        int_json=JSON.parse($('#container_pie').attr('data-int'));                   
    } 
    catch (e) {
        int_json=0;
    }
    try {
        ort_json=JSON.parse($('#container_pie').attr('data-ort'));                   
    } 
    catch (e) {
        ort_json=0;
    }
    try {
        QTL_json=JSON.parse($('#container_pie').attr('data-QTL'));                   
    } 
    catch (e) {
        QTL_json=0;
    }
    try {
        SNP_json=JSON.parse($('#container_pie').attr('data-SNP'));                   
    } 
    catch (e) {
        SNP_json=0;
    }
    
    $('#container_pie').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Title'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Scores',
            colorByPoint: true,
            data: [{
                name: 'Expression Score',

                y: exp_json
            }, {
                name: 'Interaction Score',

                y: int_json,

                sliced: true,
                selected: true
            }, {
                name: 'Orthology Score',
                y: ort_json

            }, {
                name: 'QTL Score',
                y: QTL_json

            }, {
                name: 'Genetic Markers Score',
                y: SNP_json

            }]

        }]
    });
});
//table samples
$(document).ready(function(){
    $('#samplestable').dataTable( {
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
//Datatable 
function load_table(element) {
    element.dataTable( {
    //$('#pretty_table_pv_litterature').dataTable( {
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
};
//table variants
$(document).ready(function() {
    $('#table_variants').dataTable( {
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
//old table mappings
$(document).ready(function() {
	$('#mappingSSS').dataTable( {
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
//table species
$(document).ready(function() {
	$('#species').dataTable( {
		"scrollX": false,
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
//table virus
$(document).ready(function() {
	$('#virus').dataTable( {
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
//GO_enriched_Table MF
$(document).ready(function() {
	$('#GO_enriched_TableMF').dataTable( {
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
//GO_enriched_Table CC
$(document).ready(function() {
	$('#GO_enriched_TableCC').dataTable( {
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
//GO_enriched_Table BP
$(document).ready(function() {
	$('#GO_enriched_TableBP').dataTable( {
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




//GO enrichment result table
$(document).ready(function() {
	$('#go_jobs').dataTable( {
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



