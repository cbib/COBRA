<?php
require_once '../../wiki/vendor/autoload.php';




use PhpObo\LineReader;
use PhpObo\Parser;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$start = microtime(true);
//read in obo file
$handle = fopen('../../data/mappings/gene_ontology/obo/gene_ontology.obo', 'r');
$lineReader = new LineReader($handle);
//parse file
$parser = new Parser($lineReader);
$parser->retainTrailingComments(true);
$parser->getDocument()->mergeStanzas(false); //speed tip
$parser->parse();
//loop through Term stanzas to find obsolete terms
$obsoleteTerms = array_filter($parser->getDocument()->getStanzas('Term'), function($stanza) {
    return (isset($stanza['is_obsolete']) && $stanza['is_obsolete'] == 'true');
});
echo (microtime(true) - $start), ' seconds and ', memory_get_peak_usage(true),
     ' bytes memory taken to complete.', PHP_EOL, PHP_EOL;
foreach ($obsoleteTerms as $term){
    echo $term['id'] . ' ' . $term['name'] . PHP_EOL;
}

