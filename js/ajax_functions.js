/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var profile_already_open="false";
var genetic_marker_already_open="false";
var genetic_qtl_already_open="false";
var pv_already_open="false";
var pp_already_open="false";
var orthologs_already_open="false";
var transcripts_already_open="false";
var unspliced_already_open="false";
var top_scored_gene_open="false";


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

                if(jqObj.find(".top_scored").length){
                   par=jqObj.find(".top_scored"); 
                }
                else{
                   par=jqObj.find(".no_results");
                   
                }
                
                $(".top_score_area").empty().append(par);
                load_datatable();

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
                }
                else{
                   par=jqObj.find(".no_results");
                   
                }
                
                $(".ortholog_area").empty().append(par);

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
                }
                else{
                   par=jqObj.find(".no_results");
                   
                }
                
                $(".pv_interaction_area").empty().append(par);

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
                }
                else{
                   par=jqObj.find(".no_results");
                   
                }
                
                $(".pp_interaction_area").empty().append(par);

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
                }
                else{
                   par=jqObj.find(".no_results");
                   
                }
                
                $(".genetic_markers").empty().append(par);

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
                }
                else{
                   
                   par=jqObj.find(".no_results");
                   
                }
                
                $(".qtls").empty().append(par);

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
                //alert(data);
                var jqObj = jQuery(data);
                var par=jqObj.find("#container_profile");

                $(".profile").empty().append(par);
                show_profiles(par);
                //works to load results in element
    //                        $( ".content_test" ).load( "tools/blast/blast.php #paragraph",{
    //                            search : genes,
    //
    //                            sequence : sequence
    //                            
    //                        } );



            //$( ".loading" ).load( "tools/blast/blast.php #paragraph" );
            //$('.content_test').empty().html(data);
            },
            complete:function(){  
                //   alert("stop");
                $(".loading_"+gene_id).fadeOut("slow");
                $(".profile").show("slow");
            }



        });
        profile_already_open="true";
        }
}  
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
//example datatable
$(document).ready(function() {
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
//table markers
$(document).ready(function() {
    $('#table_markers').dataTable( {
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
//table qtls
$(document).ready(function() {
    $('#table_qtls').dataTable( {
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
//table samples
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
//table pp interactions
$(document).ready(function() {
    $('#pretty_table_pp_intact').dataTable( {
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
//table pp biogrid
$(document).ready(function() {
    $('#pretty_table_pp_biogrid').dataTable( {
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
//table pp string
$(document).ready(function() {
    $('#pretty_table_pp_string').dataTable( {
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
//table pv Literature
$(document).ready(function() {
    $('#pretty_table_pv_litterature').dataTable( {
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
//table pv hpidb
$(document).ready(function() {
    $('#pretty_table_pv_hpidb').dataTable( {
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
//table orthologs
$(document).ready(function() {
    $('#orthologs_table').dataTable( {
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
//table mappings
//$(document).ready(function() {
//	$('#mapping').dataTable( {
//		"scrollX": true,
//		"jQueryUI": true,
//		"pagingType": "full_numbers",
//		"oLanguage": { 
//			"sProcessing":   "Processing...",
//			"sLengthMenu":   "display _MENU_ items",
//			"sZeroRecords":  "No item found",
//			"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
//			"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
//			"sInfoFiltered": "(filtered from _MAX_ items in total)",
//			"sInfoPostFix":  "",
//			"sSearch":       "Search: ",
//			"sUrl":          "",
//			"oPaginate": {
//				"sFirst":    "First",
//				"sPrevious": "Previous",
//				"sNext":     "Next",
//				"sLast":     "Last"
//			}
//		},
//		"language": {
//            		"decimal": ",",
//            		"thousands": "."
//        	}
//	});
//});
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
function load_datatable() {
	$('#S-genes').dataTable( {
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
}



//table multiple
//$(document).ready(function() {
//    $('#mapping').DataTable( {
//        responsive: true,
//        
//		
//        
//    } );
//    $('#species').DataTable( {
//        responsive: true,
//        
//		
//        
//    } );
//    $('#virus').DataTable( {
//        responsive: true,
//        
//		
//        
//    } );
//    $('#S-genes').DataTable( {
//        responsive: true,
//        
//		
//        
//    } );
//
//} );