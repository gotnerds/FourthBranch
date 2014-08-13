#!/usr/bin/perl -w
###!C:/xampp/perl/bin/perl.exe

use strict;
use warnings;

open(INPUT,"fourthBranch.pl") || die "Couldn't open fourthBranch.pl $!";
open(OUTPUT,">FourthBranchDocumentation.txt") || die "Couldn't open FourthBranchDocumentation.txt $!";

my $inFunction = 0;
my $functionName = '';
my @params = ();
my $outputString = "";
my $appendToOutput="";
while(<INPUT>){
    if(m@.*if\(\$function eq.*'(.*)'@){
	my $newFunctionName = $1;
	$appendToOutput .= "\n\n\t./fourthBranch.pl run=$functionName";
	for my $param (@params){
	    $appendToOutput .= " ${param}='input'";
	}
	$appendToOutput =~ s/\&$//;
	$outputString .= $appendToOutput."\n";
	my $php = &generatePhp($functionName,\@params);
	$outputString .= "\n".$php."\n\n";
	$outputString .= "*************************************\n";
    
	$functionName = $newFunctionName;
	if(!defined($functionName)){
	    print "Couldn't find functionName: $_\n";
	}
	$functionName =~ s/\s//g;
	$functionName =~ s/\W//g;
	@params = ();
	$appendToOutput = "\n*************************************\n";
	$appendToOutput = "function: $functionName";
    }
    elsif(/(.*)=.*param\('(.*)'\)/){
	my $paramName = $1;
	$paramName =~ s/my\s*//;
	$paramName =~ s/\s//g;
	$paramName =~ s/\$//g;
	#$outputString .= "$paramName='input' ";
	$appendToOutput .= "\n\t$paramName='input'";
	push(@params,$paramName);
    }
}

print OUTPUT $outputString;


sub generatePhp{
    my $functionName = $_[0];
    my $parameters_ref = $_[1];
    my @parameters = @$parameters_ref;
 
my $output = <<'END';
        if (isset($_POST['#functionName#-button'])){
            $output = shell_exec("perl ./cgi-bin/fourthBranch.pl run=#functionName# #paramList# );
            $jsonj = jsonarray($output);
        }
END
 
 
 
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
