#!/usr/bin/perl
package Databases;

use strict;
use warnings;
use CGI::Carp 'fatalsToBrowser';
use CGI qw/:standard/;
use Cwd qw(cwd abs_path);
use JSON::PP qw(decode_json encode_json);
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

# Congress votes
my $CREATE_CONGRESS_VOTES_TABLE = <<'END_CONGRESS_VOTES_TABLE';
create table congress_votes 
( id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
  vote_id VARCHAR(50),
  bill TEXT,
  date DATE,
  question TEXT,
  result VARCHAR(50),
  PRIMARY KEY (id)
);
END_CONGRESS_VOTES_TABLE
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
 title TEXT NOT NULL, 
 status VARCHAR(50), 
 url TEXT, 
 code VARCHAR(50),
 local_html TEXT,
 open VARCHAR(5),
 PRIMARY KEY(id)
);
END_BILL_TABLE
    ;

# Large Bills Table
my $CREATE_LARGE_BILL_TABLE = <<'END_LARGE_BILL_TABLE';
create table large_bills 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,
 title VARCHAR(100) NOT NULL, 
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
 title VARCHAR(100) NOT NULL, 
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
 name VARCHAR(50) NOT NULL, 
 state VARCHAR(50), 
 url TEXT, 
 email VARCHAR(50),
 phone VARCHAR(20),
 photo VARCHAR(60),
 chamber VARCHAR(50), 
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

# Comments
my $CREATE_COMMENT_TABLE = <<'END_COMMENT';
create table comments_bills 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,  
 user MEDIUMINT , 
 comment VARCHAR(200),
 sub_comment VARCHAR(200), 
 comment_post_date DATE,
 sub_comment_post_date DATE,
 PRIMARY KEY(id)
);
END_COMMENT
    ;

####################################
my @tables = ( $CREATE_INDIVIDUAL_USERS_TABLE, $CREATE_ORGANIZATION_USERS_TABLE, $CREATE_ADMIN_USERS_TABLE,$CREATE_BILL_TABLE,$CREATE_REPRESENTATIVES_TABLE,$CREATE_WALL_OF_AMERICA_TABLE,$CREATE_BILL_VOTE_TABLE,$CREATE_USER_VOTES_TABLE,$CREATE_LARGE_BILL_TABLE,$CREATE_APPROPRIATION_BILL_TABLE,$CREATE_COMMENT_TABLE,$CREATE_CONGRESS_VOTES_TABLE);

my @table_names = ("individuals", "organizations","admins","bills","representatives","bill_votes","user_votes","wall_of_america","large_bills","appropriation_bills","comments_bills","congress_votes");

####################################

sub install{
    my $dbh = $_[0];
    my $currentDir = cwd();
    my $initialData = $currentDir.'/initialData';
    if(! -e $initialData){
	print "Initial Data folder not found\n";
	exit();
    }
    LegislatorPhotos::loadImages($dbh);exit();
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
sub writeStoredProcedures{
    my $debug = 0;
    my $outputFile = $_[0];

    open(OUTPUT,">>$outputFile") || die "Couldn't open $outputFile. $!\n";
    ####################################################
    my $tableName = "bills";
    my $procedureName = "getBillByCode";
    my @columns = ("title","status","url","code", "open");
    my %whereHash = ("code"=>"bill_code");
    my @parameterList = ("code CHAR(40)");
    my $addBillProcedure = MysqlUtils::generateReadProcedureFromHash($tableName,$procedureName,\@columns,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$addBillProcedure\n";
    }
    print OUTPUT "DROP PROCEDURE `$procedureName`;\n";
    print OUTPUT "$addBillProcedure\n";
    ###################################################
    $tableName = "bills";
    $procedureName = "updateBillStatus";
    my %updateHash = ("updatedStatus"=>"status");
    %whereHash = ("code"=>"bill_code");
    @parameterList = ("updatedStatus CHAR(50)");
    my $updateBillStatus = MysqlUtils::generateWriteProcedureFromHash($tableName,$procedureName,\%updateHash,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$updateBillStatus\n";
    }
    print OUTPUT "DROP PROCEDURE `$procedureName`;\n";
    print OUTPUT "$updateBillStatus\n";
    #####################################################
    $tableName = "bills";
    $procedureName = "insertBill";
    my %insertHash = ("newStatus"=>"status","oldStatus"=>"stuff");
    my $modifierString = "";
    @parameterList = ("newStatus CHAR(50)");
    my $insertBill = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertBill\n";
    }
    print OUTPUT "DROP PROCEDURE `$procedureName`;\n";
    print OUTPUT "$insertBill\n";
    #####################################################
    $tableName = "bills";
    $procedureName = "deleteBillByCode";
    %whereHash = ("code"=>"deleteCode");
    @parameterList = ("deleteCode CHAR(40)");
    my $deleteBillProcedure = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteBillProcedure\n";
    }
    print OUTPUT "DROP PROCEDURE `$procedureName`;\n";
    print OUTPUT "$deleteBillProcedure\n";
    ###################################################

    # Remove Bill
    # Update Bill info
    # Add Admin
    # Remove Admin
    # Update Admin Password
    # Add Bill Vote
    # Add reddit vote
    # Add google vote
    # add facebook vote
    # add twitter vote
    # add Bill comment
    # add bill comment sub-comment
    # Add Individual
    # Update individual personal info
    # update individual address
    # update individual password
    # update individual activated
    # Add organization
    # update organization personal info
    # update organization address
    # update organization auxilary info
    # add related bill
    # remove related bill
    # add representative
    # remove representative
    # update representative info
    # add user vote
    # remove user vote
    # Add wall of america
    # remove wall of america
    # update wall of america
}

sub extractRelatedBills{
    my $debug = 0;
    my $dbh = $_[0];
    my $outputFile = $_[1];

    open(OUTPUT,">>$outputFile") || die "Couldn't open $outputFile. SQL Error $DBI::errstr\n";

    # Write create Related Bills command
    my $relatedTableName = "related_bills";
    my @columns = ("bill1","bill2","reason");
    my @columnTypes = ("VARCHAR(40)","VARCHAR(40)","VARCHAR(40)");
    my $createRelatedBillsTable = MysqlUtils::generateCreateString($relatedTableName,\@columns,\@columnTypes);
    if($debug == 1){
	print "Writing -->$createRelatedBillsTable\n";
	print OUTPUT $createRelatedBillsTable."\n";
    }
    
    my $billBufferColumns = "id, official_title, bill_type, status, updated_at, status_at, bill_id, subjects_top_term, enacted_as, number, short_title, introduced_at, congress, by_request, popular_title, bill_html, history, related_bills";
    my $sql = "SELECT $billBufferColumns from congress_github_bills;";
    if($debug == 1){
	print "Execute -->$sql\n";
    }
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "SQL Error: $DBI::errstr\n"; 
   while(my @row = $sth->fetchrow_array){
	my ($id, $official_title, $bill_type, $status, $updated_at, $status_at, $bill_id, $subjects_top_term, $enacted_as, $number, $short_title, $introduced_at, $congress, $by_request, $popular_title, $bill_html, $history, $related_bills) = @row;
	# Find the related bills in productions bills database
	my $related_ref = decode_json($related_bills); 
	my @relatedBills = @$related_ref; 
	for my $hash_ref (@relatedBills){
	    my %hash = %$hash_ref;
	    my $bill_id = $hash{'bill_id'};
	    my $type = $hash{'type'};
	    my $reason = $hash{'reason'};
	    if($debug == 1){
		print "Looking for Related Bill -> billId: $bill_id\ttype: $type\treason: $reason\n";
	    }
	    $sql = "SELECT id FROM congress_github_bills where (bill_id=\"$bill_id\");";
	    if($debug == 1){
		print "Execute -->$sql\n";
	    }
	    my $sth2 = $dbh->prepare($sql);
	    $sth2->execute or die "SQL Error: $DBI::errstr\n"; 
	    while(my @row = $sth2->fetchrow_array){
		# Add entry to related bills table
		my @relatedColumns = ("bill1","bill2");
		my $id = $row[0];
		my @relatedData = ($bill_id,$id);
		if($debug == 1){
		    print "Found Related Bill --> $id\n";
		    my $insert = MysqlUtils::generateInsertStringFromArray($relatedTableName,\@relatedColumns,\@relatedData);
		    print "Writing -->$insert\n";
		    print OUTPUT "$insert\n";
		}
		
	    }
	    
	}
	#my %related = %$related_ref;
	#print %related;
	
    }
}

sub extractBills{
    my $debug = 0;
    my $dbh = $_[0];
    my $outputFile = $_[1];

    open(OUTPUT,">>$outputFile") || die "Couldn't open $outputFile. SQL Error $DBI::errstr\n";

    my $tableName = "bills";
    my @columns = ("title","state","url","code","open","local_html");
    my @columnTypes = ("VARCHAR(100)","VARCHAR(50)","TEXT","VARCHAR(50)","VARCHAR(5)","TEXT");

    my $billBufferColumns = "id, official_title, bill_type, status, updated_at, status_at, bill_id, subjects_top_term, enacted_as, number, short_title, introduced_at, congress, by_request, popular_title, bill_html, history, related_bills";
    my $sql = "SELECT $billBufferColumns from congress_github_bills;";
    if($debug == 1){
	print "Execute -->$sql\n";
    }
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "SQL Error: $DBI::errstr\n"; 
    while(my @row = $sth->fetchrow_array){
	my ($id, $official_title, $bill_type, $status, $updated_at, $status_at, $bill_id, $subjects_top_term, $enacted_as, $number, $short_title, $introduced_at, $congress, $by_request, $popular_title, $localHtml, $history, $related_bills) = @row;
	if (defined($localHtml)){
	    $localHtml =~ s/.*(initialData.*)$/$1/;
	}
	my @insertBillColumns = ("title","status","url","code","open","local_html");
	my @insertBillData = ($official_title,$status,"NULL",$bill_id,"NULL",$localHtml);
	$official_title =~ s/\(/\(/g;
	$official_title =~ s/\)/\)/g;
	my $insertTableName = "bills";
	my $insertBillQuery = MysqlUtils::generateInsertStringFromArray($insertTableName,\@insertBillColumns,\@insertBillData);
	if($debug == 1){
	    print "Writing -->$insertBillQuery\n";
	}
	print OUTPUT "$insertBillQuery\n";
    }

}

sub extractRepresentatives{
    my $debug = 0;
    my $dbh = $_[0];
    my $outputFile = $_[1];

    open(OUTPUT,">>$outputFile") || die "Couldn't open $outputFile. SQL Error $DBI::errstr\n";

    my $tableName = "legislators_csv_buffer";
    my $bufferColumns = "id, title, firstname,middlename,lastname,name_suffix,nickname, party, state, district, in_office, gender, phone, fax, website, webform, congress_office, bioguide_id, votesmart_id, fec_id, govtrack_id, crp_id, twitter_id, congresspedia_url, youtube_url, facebook_id, senate_class, birthdate,oc_email";


    my $sql = "SELECT $bufferColumns from $tableName;";
    if($debug == 1){
	print "Execute -->$sql\n";
    }
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "SQL Error: $DBI::errstr\n"; 
    while(my @row = $sth->fetchrow_array){
	my ($id, $title, $firstname,$middlename,$lastname,$name_suffix,$nickname,$party, $state, $district, $in_office, $gender, $phone, $fax, $website, $webform, $congress_office, $bioguide_id, $votesmart_id, $fec_id, $govtrack_id, $crp_id, $twitter_id, $congresspedia_url, $youtube_url, $facebook_id, $senate_class, $birthdate, $oc_email) = @row;
	my @insertRepresentativesColumns = ("name","state","url","email","phone","photo","chamber");
	my @insertRepresentativesData = ($firstname . " ".$lastname,$state,$website,$oc_email,$phone,"NULL",$congress_office);
	my $insertTableName = "representatives";
	my $insertBillQuery = MysqlUtils::generateInsertStringFromArray($insertTableName,\@insertRepresentativesColumns,\@insertRepresentativesData);
	if($debug == 1){
	    print "Writing -->$insertBillQuery\n";
	}
	print OUTPUT "$insertBillQuery\n";
    }
}
sub writeCreateTables{
    my $debug = 0;
    my $outputFile = $_[0];
    open(OUTPUT,">>$outputFile") || die "Couldn't open $outputFile. SQL Error $DBI::errstr\n";
    for my $table (@table_names){
	my $sql = "DROP TABLE IF EXISTS ".$table.";";
	if($debug ==1 ){
	    print "Writing -->$sql\n";
	}
	print OUTPUT "$sql\n";
    }

    for my $index (@tables){
	my $sql = $index; 
	
	if($debug == 1){
	    print "Writing -->$sql\n";
	}
	print OUTPUT "$sql";

    }  
}

sub extractRepresentativePhotos{
    my $debug = 0;
    my $dbh = $_[0];
    my $outputFile = $_[1];

    open(OUTPUT,">>$outputFile") || die "Couldn't open $outputFile. SQL Error $DBI::errstr\n";
}

sub extractBillVotes{
    my $debug = 0;
    my $dbh = $_[0];
    my $outputFile = $_[1];

    open(OUTPUT,">>$outputFile") || die "Couldn't open $outputFile. SQL Error $DBI::errstr\n";
    # TODO identify and attach foreign keys for bill and votes
    my $voteBufferColumns =  "id, vote_id, bill, date, question, result,votes";
;
    my $sql = "SELECT $voteBufferColumns from congress_github_votes;";
    if($debug == 1){
	print "Execute -->$sql\n";
    }
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "SQL Error: $DBI::errstr\n"; 
   while(my @row = $sth->fetchrow_array){
       # Add each read vote to congress_votes table
       my ($id, $vote_id, $bill, $date, $question, $result, $votes) = @row;
       # TODO Find the related bills in productions bills database
       # TODO Add individual results generated from votes
       $date =~ /(\d{4})-(\d{2})-(\d{2}).*/;
       $date = "$1-$2-$3";
       my @voteColumns = ("vote_id","bill","date","question","result");
       my @voteData = ($vote_id,$bill,$date,$question,$result);
       my $insertVoteQuery = MysqlUtils::generateInsertStringFromArray("congress_votes",\@voteColumns,\@voteData);
	if ($debug == 1){
	    print "Writing -->$insertVoteQuery\n";
	}
	print OUTPUT "$insertVoteQuery\n";
   }
    
}

sub generateProductionDatabase{
    my $dbh = $_[0];
    my $outputFile = $_[1];
    if(-e $outputFile){
	unlink $outputFile || die "Couldn't remove $outputFile $!\n";
    }
    if(-e "loadProduction.log"){
	unlink "loadProduction.log" || die "Couldn't remove loadProduction.log $!\n";
    }
    open(OUTPUT,">>$outputFile") || die "Couldn't open $outputFile. SQL Error $DBI::errstr\n";
    print OUTPUT "\\W\n";
    print OUTPUT "tee loadProduction.log;\n";
    print OUTPUT "use fourthbranch;\n";
    &writeCreateTables($outputFile);
    &writeStoredProcedures($outputFile);
    &extractBills($dbh,$outputFile);
    &extractRelatedBills($dbh,$outputFile);
    &extractBillVotes($dbh,$outputFile);
    &extractRepresentatives($dbh,$outputFile);
    &extractRepresentativePhotos($dbh,$outputFile);
    print OUTPUT "notee;\n";
    print OUTPUT "\\w\n";
    # -Generate bill history table
    # -Insert Bills
    # congress_github_amendments
    # - Generate Actions table
    # - Generate sponsor table
    # - Generate Amends Bill table
    # - Insert Amendments
    # Output database data for production tables into file
}

1;
