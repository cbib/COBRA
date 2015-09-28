<?php
//session_start();
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('./session/control-session.php');





new_cobra_header();

new_cobra_body($_SESSION['login'],"Result Summary","section_result_summary");

echo '<div id="plot_chart" style ="width:100%"></div>';

new_cobra_footer();

?>


<script type="text/javascript" class="init">
    $(document).ready(function () { 
       //$('#expression_profile').append("<div class=\"graph\" id=\"container\"></div>");

        $('#plot_chart').highcharts({

            chart: {
                type: 'bar'
            },
            title: {
                text: 'Gene Expression'
            },
            xAxis: {
                categories: ['XP1', 'XP2', 'XP3']
            },
            yAxis: {
                title: {
                    text: 'level of differential expression '
                }
            },
            series: [{
                name: 'infected',
                data: [1, 0, 4]
            }, {
                name: 'non infected',
                data: [5, 7, 3]
            }]
        });
    });
	
</script>