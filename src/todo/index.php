<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
#red task: #FA8258
#green task: #01DF74
new_cobra_body(is_logged($_SESSION['login']),"Todo list","section_todo","../..");
echo '<ul><li style="background: #01DF74;"> Add color indicator in user page for unfinished jobs</li></ul>';
echo '<ul><li style="background: #01DF74;"> Problem with table for interaction</li></ul>';
echo '<ul><li style="background: #01DF74;"> Problem with QTLs and markers for prunus persica</li></ul>';
echo '<ul><li style="background: #01DF74;"> Scoring functions test2.py to modify</li></ul>';
echo '<ul><li style="background: #01DF74;"> Finishing table for GO enrichments results</li></ul>';
echo '<ul><li style="background: #01DF74;"> Add GO pathway enrichements using KEGG pathway and melodie method</li></ul>';
echo '<ul><li style="background: #01DF74;"> problem with COBRA depot</li></ul>';
echo '<ul><li style="background: #01DF74;"> add boxplot for sample to see logFC distributions</li></ul>';

new_cobra_footer();