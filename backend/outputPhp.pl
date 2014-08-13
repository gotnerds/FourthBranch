#!C:/xampp/perl/bin/perl.exe
###!/usr/bin/perl -w

use strict;
use warnings;
sub generatePhp{
my $output = <<'END';
if (isset($_POST['#functionName#-button'])){
        $output = shell_exec("perl ./cgi-bin/fourthBranch.pl run=#functionName# #paramList# );
        $jsonj = jsonarray($output);
}
END
 
 my $functionName = "testfunction";
 my @parameters = ('param1','param2','param3');
 my $paramPrefix = '$_POST[\'#paramName#\']';
 
 $output =~ s@#functionName#@$functionName@g;
 my $paramList = ""; 
 my $appendParam = 0;
 for my $param (@parameters){
    if($appendParam == 1){
        $paramList .= '." ';
    }
    $paramList .= $param.'=".$_POST['."'$param']";
    $appendParam = 1;
 }
 $output =~ s/#paramList#/$paramList/;
 return $output;
 }