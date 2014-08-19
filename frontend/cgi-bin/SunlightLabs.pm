#!C:/ampps/perl/bin/perl.exe
###!/usr/bin/perl -w
package SunlightLabs;

use warnings;
use CGI::Carp 'fatalsToBrowser';
use CGI qw/:standard/;
use Cwd qw(cwd abs_path);
use File::Basename 'dirname';
use lib dirname(abs_path $0);
use strict;
use Exporter;
use WWW::Mechanize;
use URI::Escape;
use vars qw($VERSION @ISA @EXPORT @EXPORT_OK %EXPORT_TAGS);

$VERSION     = 1.00;
@ISA         = qw(Exporter);
@EXPORT      = ();
@EXPORT_OK   = qw();
%EXPORT_TAGS = ( DEFAULT => [qw()]);

#########################################################
# sunlight labs api
my $baseUrl = "https://sunlightlabs.github.io/congress/";
my $legislatorLookUp = "legislators";
my $representativeSearch = "legislators/locate";
my $districtSearch = "districts/locate";
my $committeeLookup = "committees";
my $billLookup = "bills";
my $billSearch = "bills/search";
my $amendmentLookup = "amendments";
my $nominationLookup = "nominations";
my $voteLookup = "votes";
my $floorUpdates = "floor_updates";
my $hearingLookup = "hearings";
my $upcomingBillsLookup = "upcoming_bills";
my $apiStatusCheck = "https://congress.api.sunlightfoundation.com";
my $apiKey = "apikey=ab7c0a8225a9414dbd2eae25af5f9a31";
my $startParam = "?";
my $appendParam = "&";
my $fieldParam = "fields=";
my $greaterThan = "__gt=";
my $greaterThanOrEqual = "__gte=";
my $lessThan = "__lt=";
my $lessThanOrEqual = "__lte=";
my $not = "__not=";
my $all = "__all=";
my $in = "__in=";
my $notIn = "__nin=";
my $exists = "__exists=";
my $page = "page=";
my $resultOrder = "order";
my $ascending = "__asc";
my $descending = "__desc";
my $search = "query=";
my $explain = "explain=true";
##########################################################
my $mech = WWW::Mechanize->new( 'ssl_opts' => { 'verify_hostname' => 0 } );
