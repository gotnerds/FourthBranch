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
my $appendParam = 0;
while(<INPUT>){
    
    my $recognizeFunction = '$function eq';
    if(m@.*if\(\$function eq(.*)$@){
	$appendToOutput .= "\n\n\t./fourthBranch.pl run=$functionName ";
	for my $param (@params){
	    $appendToOutput .= "${param}='input'";
	    if($appendParam == 1){
		$appendToOutput .= '&';
	    }
	    $appendParam = 1;
	}
	$appendToOutput =~ s/\&$//;
	$outputString .= $appendToOutput."\n";
	
	$functionName = $1;
	$functionName =~ s/\s//g;
	$functionName =~ s/\W//g;
	$appendParam = 0;
	@params = ();
	$appendToOutput = "\nfunction: $functionName";
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
