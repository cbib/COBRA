<?php 
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('./session/control-session.php');
$db=mongoConnector();

	$grid = $db->getGridFS();
	//Selection des collections
	$samplesCollection = new MongoCollection($db, "samples");
	$speciesCollection = new Mongocollection($db, "species");
	$mappingsCollection = new Mongocollection($db, "mappings");
	$measurementsCollection = new Mongocollection($db, "measurements");
	$virusesCollection = new Mongocollection($db, "viruses");
	$interactionsCollection = new Mongocollection($db, "interactions");
	$orthologsCollection = new Mongocollection($db, "orthologs");
    $GOCollection = new Mongocollection($db, "gene_ontology");
echo '
<!DOCTYPE html>
<html>
<head>
<title>PLATO DataBase</title>
<meta charset="UTF-8" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<script src="https://services.cbib.u-bordeaux2.fr/cobra/js/jquery.min.js"></script>
<script src="https://services.cbib.u-bordeaux2.fr/cobra/css/Highcharts-4.1.8/js/highcharts.js"></script>
<script src="https://services.cbib.u-bordeaux2.fr/cobra/css/Highcharts-4.1.8/js/modules/exporting.js"></script>

</head>
<body>';
echo'<div id="expression_profile">
                    <h3>Expression profile</h3>
                    <div class="panel-group" id="accordion_documents_expression">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                
                                    <a class="accordion-toggle collapsed" href="#expression-chart" data-parent="#accordion_documents_expression" data-toggle="collapse">
                                        <strong>Expression data</strong>
                                    </a>				
                           
                            </div>
                            <div class="panel-body panel-collapse collapse" id="expression-chart">
                                <div id="container" style="min-width: 310px; height: 400px;"></div>
                            </div>

                        </div>
                    </div>';
                $cursor=$measurementsCollection->find(array('$or'=> array(array('gene'=>'AT1G75950'),array('gene'=>'AT1G75950'))),array('_id'=>0));
                $counter=1;
                $series=array();
                $categories=array();
                foreach ($cursor as $result) {
//                    $sample=array(
//                        'name'=>'Day post inoc '.$result['day_after_inoculation'],
//                        //'infection_agent'=>"Tobacco etch virus",
//                        'data'=>[(float) $result['logFC']]
//                    );
                    array_push($series, $sample);
                    array_push($categories, $result['variety']);
                    //echo 'experiment full name: '.$result['xp'].'<br>';
                    $xp_full_name=explode(".", $result['xp']);                   
                    $experiment_id=$xp_full_name[0];
                    $xp_name=get_experiment_name_with_id($samplesCollection,$experiment_id);
                    $counter++;

                }

                echo'<div id="shift_line"></div>'
                . '</div></body>
                </html>';

    

?>

<script type="text/javascript" class="init">

$(function(){
    $('#container2').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart'
        },
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, {
            name: 'Jane',
            data: [2, 2, 3, 2, 1]
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
        }]
    });
});

</script>