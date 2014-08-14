#!/usr/bin/perl 
use strict;
use warnings; 
use Cwd qw(cwd abs_path);
use JSON::PP qw(decode_json encode_json);

my $CURRENT_DIRECTORY = cwd();

opendir(BILLS_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/bills") || die "Couldn't open the bills directory. $!";
my @billTypes;
while(my $billType = readdir(BILLS_FOLDER)){
    if($billType ne "." && $billType ne ".." && $billType ne ".DS_Store"){
	push(@billTypes,$billType);
    }
}
my @billTypeNumbers;
for my $billType (@billTypes){
    opendir(BILL_TYPE_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/bills/$billType") || die "Couldn't open the bills directory. $!";
    while(my $billTypeNumber = readdir(BILL_TYPE_FOLDER)){
	if($billTypeNumber ne "." && $billTypeNumber ne ".." && $billTypeNumber ne ".DS_Store"){
	    push(@billTypeNumbers,$CURRENT_DIRECTORY."/initialData/congress113_data/bills/$billType/".$billTypeNumber);
	}
    }
}

for my $individualBill (@billTypeNumbers){
    open(BILL, $individualBill."/data.json") || die "Couldn't open the bills directory. $!";
    my @inputFile = <BILL>;
    my $inputFile = join("",@inputFile);
    my $perl_scalar = decode_json($inputFile);
    print $perl_scalar; <STDIN>;
}

opendir(AMENDMENTS_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/amendments") || die "Couldn't open the amendments directory. $!";
my @amendmentTypes;
while(my $amendmentType = readdir(AMENDMENTS_FOLDER)){
    if($amendmentType  ne "." && $amendmentType ne ".." && $amendmentType ne ".DS_Store"){
	push(@amendmentTypes,$amendmentType);
    }
}


opendir(VOTES_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/votes/2014") || die "Couldn't open the votes directory. $!";
my @voteTypes;
while(my $voteType = readdir(BILLS_FOLDER)){
    if($voteType ne "." && $voteType ne ".." && $voteType ne ".DS_Store"){
	push(@voteTypes,$voteType);
    }
}
