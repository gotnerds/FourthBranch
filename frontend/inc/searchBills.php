<?php 
function search_split_terms($terms){

	$terms = preg_replace("/\"(.*?)\"/e", "search_transform_term('\$1')", $terms);
	$terms = preg_split("/\s+|,/", $terms);

	$out = array();

	foreach($terms as $term){

		$term = preg_replace("/\{WHITESPACE-([0-9]+)\}/e", "chr(\$1)", $term);
		$term = preg_replace("/\{COMMA\}/", ",", $term);

		$out[] = $term;
	}

	return $out;
}

function search_transform_term($term){
	$term = preg_replace("/(\s)/e", "'{WHITESPACE-'.ord('\$1').'}'", $term);
	$term = preg_replace("/,/", "{COMMA}", $term);
	return $term;
}

function search_escape_rlike($string){
	return preg_replace("/([.\[\]*^\$])/", '\\\$1', $string);
}

function search_db_escape_terms($terms){
	$out = array();
	foreach($terms as $term){
		$out[] = '[[:<:]]'.AddSlashes(search_escape_rlike($term)).'[[:>:]]';
	}
	return $out;
}

function search_db_escape_category($terms){
	$out = array();
	foreach($terms as $term){
		$out[] = AddSlashes(search_escape_rlike($term));
	}
	return $out;
}
function search_perform($terms){

	$terms = search_split_terms($terms);
	$terms_db = search_db_escape_terms($terms);

	$parts = array();
	foreach($terms_db as $term_db){
		$parts[] = "title RLIKE '$term_db'";
	}
	if (isset($_POST['proposal-submit'])){
	$parts = implode(' OR ', $parts);
	$ids = $_POST["category"];
	$ids_db = search_db_escape_category($ids);
	$category = array();
	foreach ($ids_db as $ids_db) {
		$category[] = "subject = '$ids_db'" ;
	}
	
	$cat = implode(' OR ', $category);
	$sql = "SELECT * FROM bills WHERE $parts and $cat ORDER BY id DESC LIMIT ?,?";
	} else {
	$parts = implode(' AND ', $parts);
	}
	$sql = "SELECT * FROM bills WHERE $parts ORDER BY id DESC LIMIT ?,?";
	return $sql;
}
