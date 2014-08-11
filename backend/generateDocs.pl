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
	
	$functionName = $newFunctionName;
	if(!defined($functionName)){
	    print "Couldn't find functionName: $_\n";
	}
	$functionName =~ s/\s//g;
	$functionName =~ s/\W//g;
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
