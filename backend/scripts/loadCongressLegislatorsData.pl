#!/usr/bin/perl

use strict;
use warnings;
use YAML::Tiny;
use Data::Dumper;
my $yaml = YAML::Tiny->read("testData/legislators-current.yaml");

# Get a reference to the first document
my $config_ref = $yaml->[0];
my @documents = @$config_ref;
my $index = 0;
for my $document (@documents){
    my $hashref = $document;
    my %individual = %$hashref;
    #my @content = $document[0];
    for my $key (keys(%individual)){
	#print "key -> $key\n";
    }
    my $nameRef = $individual{'name'};
    my %nameHash = %$nameRef;
    my $termsRef = $individual{'terms'};
    my @termsArray = @$termsRef;

    my $idRef = $individual{'id'};
    my %idHash = %$idRef;

    my $bioRef = $individual{'bio'};
    my $bioHash = %$bioRef;
    
    $index++;
}
print "length: $index";
