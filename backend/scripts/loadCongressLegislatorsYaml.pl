#!/usr/bin/perl
# Used to parse legislators-current.yaml from congress-legislators. Unused.
# Need to parse legislators-social-media.yaml to replace using the .csv file
use strict;
use warnings;
use YAML::Tiny;
use Data::Dumper;
my $yaml = YAML::Tiny->read("/home/spooky/git/FourthBranch/backend/initialData/congress-legislators/legislators-current.yaml");

# Get a reference to the first document
my $config_ref = $yaml->[0];
my @documents = @$config_ref;
my $index = 0;

for my $document (@documents){
    # reset document results
    my %result; 
    $result{'title'} = "";
    $result{'first'} = "";
    $result{'last'} = "";
    $result{'official_full'} = "";
    $result{'party'} = "";
    $result{'state'} = "";
    $result{'district'} = "";
    $result{'phone'} = "";
    $result{'url'} = "";
    $result{'contact_form'} = "";
    $result{'bioguide'} = "";
    $result{'bioguide'} = "";
    $result{'thomas'} = "";
    $result{'lis'} = "";
    $result{'govtrack'} = "";
    $result{'opensecrets'} = "";
    $result{'votesmart'} = "";
    $result{'fec_senate'} = "";
    $result{'fec_house'} = "";
    $result{'cspan'} = "";
    $result{'wikipedia'} = "";
    $result{'house_history'} = "";
    $result{'ballotpedia'} = "";
    $result{'maplight'} = "";
    $result{'washington_post'} = "";
    $result{'icpsr'} = "";
    
    ########################
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
    # TODO search terms for most the latest end date
    # then extract Type -> title
    # Party -> party
    # state -> state
    # district -> district
    # phone -> phone
    # url -> website
    # contact_form -> webform
    
    
    my $idRef = $individual{'id'};
    my %idHash = %$idRef;
    # all id fields
    my $bioRef = $individual{'bio'};
    my $bioHash = %$bioRef;
    # get birthdate
    
   
    $index++;
}
print "length: $index";
