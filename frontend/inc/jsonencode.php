<?php
function jsonarray($a){
      $matches = array();
      preg_match_all('/\{([^}]+)\}/', $a, $matches);
      $json = implode($matches[0]);
      $jsonj = json_decode($json);
      return $jsonj;
}
?>