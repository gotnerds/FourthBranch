#!/usr/bin/perl -w
###!C:/xampp/perl/bin/perl.exe
package Databases;

use strict;
use warnings;
use CGI::Carp 'fatalsToBrowser';
use CGI qw/:standard/;
use Cwd qw(cwd abs_path);
use File::Basename 'dirname';
use lib dirname(abs_path $0);
use Data::Dump qw(pp);
use Exporter;
use vars qw($VERSION @ISA @EXPORT @EXPORT_OK %EXPORT_TAGS);
use CongressGithub qw(:DEFAULT);
use CurrentLegislatorsCsv qw(:DEFAULT);
use LegislatorPhotos;

$VERSION     = 1.00;
@ISA         = qw(Exporter);
@EXPORT      = qw(install);
@EXPORT_OK   = qw(install createBackendTables dropBackendTables);
%EXPORT_TAGS = ( DEFAULT => [qw(&install &createBackendTables &dropBackendTables)]);

# Individual Users
my $CREATE_INDIVIDUAL_USERS_TABLE = <<'END_INDIVIDUAL_USERS_TABLE';
create table individuals 
( id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
  first_name VARCHAR(50) NOT NULL UNIQUE , 
  last_name VARCHAR(50) NOT NULL,
  username VARCHAR(30) NOT NULL, 
  birthdate DATE NOT NULL,
  gender CHAR(1), 
  address VARCHAR(200), 
  city VARCHAR(200), 
  state VARCHAR(100), 
  zip MEDIUMINT,
  email VARCHAR(100),
  password VARCHAR(100), 
  political_affiliation VARCHAR(30), 
  activated VARCHAR(5), 
  PRIMARY KEY (id)
);
END_INDIVIDUAL_USERS_TABLE
    ;

# Organization Users
my $CREATE_ORGANIZATION_USERS_TABLE = <<'END_ORGANIZATION_USERS_TABLE';
create table organizations 
( id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
  name VARCHAR(50) NOT NULL UNIQUE, 
  address VARCHAR(200), 
  city VARCHAR(200),
  state VARCHAR(100), 
  zip MEDIUMINT,
  phone VARCHAR(100),
  legal_status VARCHAR(100), 
  cause_concerns VARCHAR(30),
  join_reason VARCHAR(500),
  individual_name VARCHAR(300), 
  title_in_organization VARCHAR(300), 
  personal_phone VARCHAR(20), 
  email VARCHAR(40), 
  password VARCHAR(30), 
  verified VARCHAR(5), 
  signup_date DATE,
  PRIMARY KEY (id)
);
END_ORGANIZATION_USERS_TABLE
    ;

# Admin Users
my $CREATE_ADMIN_USERS_TABLE = <<'END_ADMIN_USERS_TABLE';
create table admins 
( id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,
  email VARCHAR(50) NOT NULL UNIQUE, 
  password VARCHAR(200), 
  PRIMARY KEY (id)
);
END_ADMIN_USERS_TABLE
    ;



# Normal Bills
my $CREATE_BILL_TABLE = <<'END_BILL_TABLE';
create table bills 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
 title VARCHAR(100) NOT NULL UNIQUE, 
 state VARCHAR(50), 
 url TEXT, 
 code VARCHAR(50),
 open VARCHAR(5),
 PRIMARY KEY(id)
);
END_BILL_TABLE
    ;

# Large Bills Table
my $CREATE_LARGE_BILL_TABLE = <<'END_LARGE_BILL_TABLE';
create table large_bills 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,
 title VARCHAR(100) NOT NULL UNIQUE, 
 state VARCHAR(50), 
 url TEXT, 
 code VARCHAR(50),
 open VARCHAR(5),
 num_sections MEDIUMINT, 
 section_num MEDIUMINT, 
 section_name VARCHAR(40),
 section_content VARCHAR(40),
 voteCountYes MEDIUMINT,
 voteCountNo MEDIUMINT,
 individualVote MEDIUMINT,
 PRIMARY KEY(id)
);
END_LARGE_BILL_TABLE
    ;

# Appropriation Bills Table
my $CREATE_APPROPRIATION_BILL_TABLE = <<'END_APPROPRIATION_BILL_TABLE';
create table appropriation_bills 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,
 title VARCHAR(100) NOT NULL UNIQUE, 
 state VARCHAR(50), 
 url TEXT, 
 code VARCHAR(50),
 open VARCHAR(5),
 num_sections MEDIUMINT,
 budget MEDIUMINT,
 section_name MEDIUMINT,
 section_allocation MEDIUMINT,
 num_objects MEDIUMINT,
 object_name MEDIUMINT,
 object_allocation MEDIUMINT,
 PRIMARY KEY(id)
);
END_APPROPRIATION_BILL_TABLE
    ;
 
#
# Representatives
my $CREATE_REPRESENTATIVES_TABLE = <<'END_REPRESENTATIVES_TABLE';
create table representatives 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
 name VARCHAR(50) NOT NULL UNIQUE, 
 state VARCHAR(50), 
 url TEXT, 
 email VARCHAR(50),
 phone VARCHAR(5),
 photo VARCHAR(60),
 chamber VARCHAR(10), 
 PRIMARY KEY(id)
);
END_REPRESENTATIVES_TABLE
    ;

# Bill Vote 
my $CREATE_BILL_VOTE_TABLE = <<'END_BILL_VOTE_TABLE';
create table bill_votes 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
 billId MEDIUMINT NOT NULL, 
 reddit MEDIUMINT , 
 google MEDIUMINT, 
 facebook MEDIUMINT,
 twitter MEDIUMINT,
 PRIMARY KEY(id)
);
END_BILL_VOTE_TABLE
    ;

# User Votes 
my $CREATE_USER_VOTES_TABLE = <<'END_USER_VOTES_TABLE';
create table user_votes 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
 billId MEDIUMINT NOT NULL, 
 user MEDIUMINT , 
 vote VARCHAR(200), 
 date DATE,
 PRIMARY KEY(id)
);
END_USER_VOTES_TABLE
    ;
 
# WallOfAmerica
my $CREATE_WALL_OF_AMERICA_TABLE = <<'END_WALL_OF_AMERICA';
create table wall_of_america 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,  
 user MEDIUMINT , 
 dream VARCHAR(200),
 wish VARCHAR(200), 
 date DATE,
 PRIMARY KEY(id)
);
END_WALL_OF_AMERICA
    ;
####################################
my @tables = ( $CREATE_INDIVIDUAL_USERS_TABLE, $CREATE_ORGANIZATION_USERS_TABLE, $CREATE_ADMIN_USERS_TABLE,$CREATE_BILL_TABLE,$CREATE_REPRESENTATIVES_TABLE,$CREATE_WALL_OF_AMERICA_TABLE,$CREATE_BILL_VOTE_TABLE,$CREATE_USER_VOTES_TABLE,$CREATE_LARGE_BILL_TABLE,$CREATE_APPROPRIATION_BILL_TABLE);

my @table_names = ("individuals", "organizations","admins","bills","representatives","bill_votes","user_votes","wall_of_america","large_bills","appropriation_bills");

####################################

sub install{
    my $dbh = $_[0];
    &dropBackendTables($dbh);
    &createBackendTables($dbh);
    # Load External Api Buffers
    CurrentLegislatorsCsv::loadLegislatorsCsv($dbh);
    CongressGithub::loadCongressGithubBills($dbh);
    CongressGithub::loadCongressGithubVotes($dbh);
    CongressGithub::loadCongressGithubAmendments($dbh);
    LegislatorPhotos::loadImages($dbh);

}

sub createBackendTables{
    my $debug = 0;
    my $dbh = $_[0];
    if(!defined($dbh)){
	print "Undefined DBH !!!\n";
	exit();
    }
    print "Creating FourthBranch Tables\n";
    for my $index (@tables){
	my $sql = $index; 
	
	if($debug == 1){
	    print "Execute -->$sql\n\n";
	}
	my $sth = $dbh->prepare($sql);
	$sth->execute or die "Create Backend Tables: SQL Error: $DBI::errstr\n";
    }
}

sub dropBackendTables{
    my $debug = 0;
    my $dbh = $_[0];
    if(!defined($dbh)){
	print "Undefined DBH !!!\n";
	exit();
    }
    print "Dropping fourth branch tables\n";
    for my $table (@table_names){
	my $sql = "DROP TABLE IF EXISTS ".$table.";";
	if($debug ==1 ){
	    print "Execute -->$sql\n\n";
	}
	my $sth = $dbh->prepare($sql);
	$sth->execute or die "Drop Backend Tables: SQL Error: $DBI::errstr\n"; 
    }
}
sub loadProduction{
    my $inputFile = $_[0];
}

sub sanitize{
    my $outputFile = $_[0];
    # congress_github_bills
    # -Generate the related bills table from congress_github_bills:related_bills
    # -Generate bill history table
    # -Insert Bills
    # congress_github_amendments
    # - Generate Actions table
    # - Generate sponsor table
    # - Generate Amends Bill table
    # - Insert Amendments
    # Output database data for production tables into file
}

sub loadTestData{
    my $dbh = $_[0];
    my $curDir = cwd();
    my @tableFiles = (
	[$curDir."/testData/.csv","dsd"],
	[$curDir."/testData/.csv","ud"],
	[$curDir."/testData/.csv","fs"],
	[$curDir."/testData/.csv","ef"],
	[$curDir."/testData/.csv","g"],
	[$curDir."/testData/.csv","r"]
	);
    for(my $index = 0; $index < @tableFiles;$index++){
	my $fileName = $tableFiles[$index][0];
	my $tableName = $tableFiles[$index][1];
	my $sql = "LOAD DATA LOCAL INFILE '".$fileName."' INTO TABLE ".$tableName.
	    " FIELDS TERMINATED BY ',' LINES TERMINATED BY '\\n' ".
	    "IGNORE 1 LINES;";
	print $sql."\n";
	my $sth = $dbh->prepare($sql);
	$sth->execute or die "Get Load Test Data: SQL Error: $DBI::errstr\n";
    }

    
}
1;
