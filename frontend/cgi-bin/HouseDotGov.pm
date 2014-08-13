#!/usr/bin/perl -w
###!C:/xampp/perl/bin/perl.exe
package HouseDotGov;

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
@EXPORT_OK   = qw(getUserRepresentativeWebPage findUserRepresentative);
%EXPORT_TAGS = ( DEFAULT => [qw(&func1findUserRepresentative &getUserRepresentativeWebPage)]);


my $mech = WWW::Mechanize->new();
my $representativeSearchUrl = 'http://www.house.gov/htbin/findrep?ADDRLK31154111031154111&street=&city=&state=&ZIP=';


my %houseStateCode = (
    "Alabama" => "ALAlabama",
    "Alaska" => "AKAlaska",
    "American Samoa" => "ASAmerican Samoa",
    "Arizona" => "AZArizona",
    "Arkansas" => "ARArkansas",
    "California" => "CACalifornia",
    "Colorado" => "COColorado",
    "Connecticut" => "CTConnecticut",
    "Delaware" => "DEDelaware",
    "District of Columbia" => "DCDistrict of Columbia",
    "Florida" => "FLFlorida",
    "Georgia" => "GAGeorgia",
    "Guam" => "GUGuam",
    "Hawaii" => "HIHawaii",
    "Idaho" => "IDIdaho",
    "Illinois" => "ILIllinois",
    "Indiana" => "INIndiana",
    "Iowa" => "IAIowa",
    "Kansas" => "KSKansas",
    "Kentucky" => "KYKentucky",
    "Louisiana" => "LALouisiana",
    "Maine" => "MEMaine",
    "Maryland" => "MDMaryland",
    "Massachusetts" => "MAMassachusetts",
    "Michigan" => "MIMichigan",
    "Minnesota" => "MNMinnesota",
    "Mississippi" => "MSMississippi",
    "Missouri" => "MOMissouri",
    "Montana" => "MTMontana",
    "Nebraska" => "NENebraska",
    "Nevada" => "NVNevada",
    "New Hampshire" => "NHNew Hampshire",
    "New Jersey" => "NJNew Jersey",
    "New Mexico" => "NMNew Mexico",
    "New York" => "NYNew York",
    "North Carolina" => "NCNorth Carolina",
    "North Dakota" => "NDNorth Dakota",
    "Northern Mariana Islands" => "MPNorthern Mariana Islands",
    "Ohio" => "OHOhio",
    "Oklahoma" => "OKOklahoma",
    "Oregon" => "OROregon",
    "Pennsylvania" => "PAPennsylvania",
    "Puerto Rico" => "PRPuerto Rico",
    "Rhode Island" => "RIRhode Island",
    "South Carolina" => "SCSouth Carolina",
    "South Dakota" => "SDSouth Dakota",
    "Tennessee" => "TNTennessee",
    "Texas" => "TXTexas",
    "Utah" => "UTUtah",
    "Vermont" => "VTVermont",
    "Virgin Islands" => "VIVirgin Islands",
    "Washington" => "WAWashington",
    "West Virginia" => "WVWest Virginia",
    "Wisconsin" => "WIWisconsin",
    "Wyoming" => "WYWyoming",
);



sub findUserRepresentative{
    my $street = $_[0];
    my $city = $_[1];
    my $state = $_[2];
    my $zip = $_[3];
    
    my $url = &getUserRepresentativeWebPage($street,$city,$state,$zip);
    $mech->get($url);
    my $content = $mech->content();
    #print $content; <STDIN>;
    # Parse address looked up
    $content =~ m@.*Street:(.*?)Zip@s;
    my $providedStreet = $1;
    $providedStreet =~ s/City(.*)//g;
    # Remove br tags
    $providedStreet =~ s@<br>@@g;
    $providedStreet =~ s@\n@@g;
    $providedStreet =~ s/^\s+//;
    $providedStreet =~ s/\s+$//;
    
    $content =~ m@.*City:(.*?)Zip@s;
    my $providedCity = $1;
    $providedCity =~ s@<br>@@g;
    $providedCity =~ s@\n@@g;
    $providedCity =~ s/^\s+//;
    $providedCity =~ s/\s+$//;

    $content =~ m@.*Zip Code:(.*?)<br>@s;
    my $providedZip = $1;
    $providedZip =~ s@\n@@g;
    $providedZip =~ s/^\s+//;
    $providedZip =~ s/\s+$//;

    
    # Parsed district
    $content =~ m@.*is located in the (.*?)<p>@s;
    my $foundDistrict = $1;
    $foundDistrict =~ s@\n@@g;
    $foundDistrict =~ s/^\s+//;
    $foundDistrict =~ s/\s+$//;

    # Parsed possible reps
    $content =~ m@.*?id="RepInfo">(.*?)</a>@s;
    my $possibleReps = $1;
    $possibleReps =~ s@.*>@@s;
    $possibleReps =~ s@\n@@g;
    $possibleReps =~ s/^\s+//;
    $possibleReps =~ s/\s+$//;

    my @results = ($providedStreet,$providedCity,$providedZip,$foundDistrict,$possibleReps);
    return \@results;
}

sub getUserRepresentativeWebPage{
    my $street = uri_escape($_[0]);
    my $city = uri_escape($_[1]);
    my $state = $_[2];
    $state = $houseStateCode{$state};
    $state = uri_escape($state);
    my $zip = uri_escape($_[3]);

    $representativeSearchUrl =~ s/street=/street=$street/;
    $representativeSearchUrl =~ s/city=/city=$city/;
    $representativeSearchUrl =~ s/state=/state=$state/;
    $representativeSearchUrl =~ s/ZIP=/ZIP=$zip/;
    return $representativeSearchUrl;

}



1;
