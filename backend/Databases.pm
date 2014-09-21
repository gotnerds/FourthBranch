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

##############################################################
# Tables from http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL
my $CREATE_MEMBERS_TABLE = <<'END_MEMBERS_TABLE';
CREATE TABLE `members` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(30) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `password` CHAR(128) NOT NULL,
    `salt` CHAR(128) NOT NULL,
    `individual_id` INT
) ENGINE = InnoDB;

END_MEMBERS_TABLE

my $CREATE_LOGIN_ATTEMPTS_TABLE = <<'END_LOGIN_ATTEMPTS_TABLE';
CREATE TABLE `login_attempts` (
    `user_id` INT(11) NOT NULL,
    `time` VARCHAR(30) NOT NULL
    ) ENGINE=InnoDB;

END_LOGIN_ATTEMPTS_TABLE
    ;

my $CREATE_UNAPPROVED_PROFILES_TABLE = <<'END_UNAPPROVED_PROFILES_TABLE';
create table unapproved_profiles
( id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
  organization_id MEDIUMINT , 
  individual_id MEDIUMINT,
  status VARCHAR(20) NOT NULL,
  PRIMARY KEY (id)
);
END_UNAPPROVED_PROFILES_TABLE
    ;

my $CREATE_REPORTED_COMMENTS_TABLE = <<'END_REPORTED_COMMENTS_TABLE';
create table reported_comments
( id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
  submitted_by VARCHAR(100) NOT NULL , 
  date DATE NOT NULL,
  relevant_bill MEDIUMINT NOT NULL, 
  status VARCHAR(20) NOT NULL,
  PRIMARY KEY (id)
);
END_REPORTED_COMMENTS_TABLE
    ;

# End  Tables from http://www.wikihow.com
###################################################################
# Individual Users
my $CREATE_INDIVIDUAL_USERS_TABLE = <<'END_INDIVIDUAL_USERS_TABLE';
create table individuals 
( id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
  first_name VARCHAR(50) NOT NULL, 
  last_name VARCHAR(50) NOT NULL,
  username VARCHAR(30) NOT NULL, 
  birthdate DATE NOT NULL,
  gender CHAR(1), 
  address VARCHAR(200), 
  city VARCHAR(200), 
  state VARCHAR(100), 
  zip MEDIUMINT,
  email VARCHAR(128),
  password VARCHAR(100), 
  political_affiliation VARCHAR(30), 
  activated VARCHAR(5), 
  salt VARCHAR(128),
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
  password VARCHAR(128), 
  salt VARCHAR(128),
  verified VARCHAR(5), 
  signup_date DATE,
  PRIMARY KEY (id)
);
END_ORGANIZATION_USERS_TABLE
    ;


my $CREATE_PROPOSAL_TABLE = <<'END_PROPOSAL_TABLE';
create table proposals 
( id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
  individual_id MEDIUMINT NOT NULL,
  name VARCHAR(50) NOT NULL, 
  concern VARCHAR(200), 
  category1 VARCHAR(100),
  category2 VARCHAR(100), 
  category3 VARCHAR(100),
  created DATE,
  verified VARCHAR(1), 
  description TEXT,
  PRIMARY KEY (id)
);
END_PROPOSAL_TABLE
    ;

# Admin Users
my $CREATE_ADMIN_USERS_TABLE = <<'END_ADMIN_USERS_TABLE';
create table admins 
( id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,
  email VARCHAR(50) NOT NULL UNIQUE, 
  password VARCHAR(128),
  salt VARCHAR(128),
  PRIMARY KEY (id)
);
END_ADMIN_USERS_TABLE
    ;

# News
my $CREATE_NEWS_TABLE = <<'END_NEWS_TABLE';
create table news 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
 title TEXT NOT NULL, 
 news_url VARCHAR(100), 
 photo VARCHAR(50),
 category VARCHAR(50),
 category_index MEDIUMINT,
 PRIMARY KEY(id)
);
END_NEWS_TABLE
    ;

# Static webpages
my $CREATE_STATIC_PAGES_TABLE = <<'END_STATIC_PAGES_TABLE';
create table static_pages 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
 page_title TEXT NOT NULL, 
 text_blob1 TEXT, 
 text_blob2 TEXT,
 text_blob3 TEXT,
 text_blob4 TEXT,
 picture1 VARCHAR(200),
 picture2 VARCHAR(200),
 picture3 VARCHAR(200),
 picture4 VARCHAR(200),
 PRIMARY KEY(id)
);
END_STATIC_PAGES_TABLE
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
 local_json TEXT,
 local_xml TEXT,
 is_large_bill CHAR(1) NOT NULL,
 is_appropiation_bill CHAR(1) NOT NULL,
 subject VARCHAR(100),
 PRIMARY KEY(id)
);

END_BILL_TABLE
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
 user_id MEDIUMINT , 
 organization_id MEDIUMINT,
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
my @tables = ($CREATE_MEMBERS_TABLE,$CREATE_LOGIN_ATTEMPTS_TABLE, $CREATE_INDIVIDUAL_USERS_TABLE, $CREATE_ORGANIZATION_USERS_TABLE, $CREATE_ADMIN_USERS_TABLE,$CREATE_BILL_TABLE,$CREATE_REPRESENTATIVES_TABLE,$CREATE_WALL_OF_AMERICA_TABLE,$CREATE_BILL_VOTE_TABLE,$CREATE_USER_VOTES_TABLE,$CREATE_COMMENT_TABLE,$CREATE_CONGRESS_VOTES_TABLE,$CREATE_NEWS_TABLE,$CREATE_REPORTED_COMMENTS_TABLE,$CREATE_PROPOSAL_TABLE,$CREATE_STATIC_PAGES_TABLE);

my @table_names = ("members","login_attempts","individuals", "organizations","admins","bills","representatives","bill_votes","user_votes","wall_of_america","comments_bills","congress_votes","news","reported_comments","proposals","static_pages");

####################################

sub install{
    my $dbh = $_[0];
    my $currentDir = cwd();
    my $initialData = $currentDir.'/initialData';
    if(! -e $initialData){
	print "Initial Data folder not found\n";
	exit();
    }
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
    print OUTPUT 'DELIMITER $$'."\n";
    ####################################################
    my $tableName = "bills";
    my $procedureName = "getBillByCode";
    my @columns = ("title","status","url","code", "open");
    my %whereHash = ("code"=>"bill_code");
    my @parameterList = ("code CHAR(40)");
    my $getBillByCodeProcedure = MysqlUtils::generateReadProcedureFromHash($tableName,$procedureName,\@columns,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$getBillByCodeProcedure\n";
    }
    print OUTPUT "$getBillByCodeProcedure\n";
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
    print OUTPUT "$updateBillStatus\n";
    #####################################################
    $tableName = "bills";
    $procedureName = "insertBill";
    my %insertHash = (
	"title" => "title", 
	"status" => "status", 
	"url" => "url", 
	"code" => "code",
	"local_html" => "local_html",
	"open" => "open",
	"local_json" => "local_json",
	"local_xml" => "local_xml",
	"isLargeBill" => "is_large_bill",
	"isAppropiationBill" => "is_appropiation_bill"	
	);
    my $modifierString = "";
    @parameterList = (
	"title TEXT", 
	"status VARCHAR(50)", 
	"url TEXT", 
	"code VARCHAR(50)",
	"local_html TEXT",
	"open VARCHAR(5)",
	"local_json TEXT",
	"local_xml TEXT",
	"isLargeBill CHAR(1)",
	"isAppropiationBill CHAR(1)" 
	);
    my $insertBill = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertBill\n";
    }
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
    print OUTPUT "$deleteBillProcedure\n";
    ###################################################
    $tableName = "bills";
    $procedureName = "makeBillLargeBill";
    %updateHash = ("isLargeBill"=>"is_large_bill");
    %whereHash = ("billid"=>"id");
    @parameterList = ("isLargeBill CHAR(1)","billid MEDIUMINT");
    my $makeBillLargeBill = MysqlUtils::generateWriteProcedureFromHash($tableName,$procedureName,\%updateHash,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$makeBillLargeBill\n";
    }
    print OUTPUT "$makeBillLargeBill\n";
    ###################################################
    $tableName = "bills";
    $procedureName = "makeBillAppropiationBill";
    %updateHash = ("isAppropiationBill"=>"is_appropiation_bill");
    %whereHash = ("billid"=>"id");
    @parameterList = ("isAppropiationBill CHAR(1)","billid MEDIUMINT");
    my $makeBillAppropiationBill = MysqlUtils::generateWriteProcedureFromHash($tableName,$procedureName,\%updateHash,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$makeBillAppropiationBill\n";
    }
    print OUTPUT "$makeBillAppropiationBill\n";
    ###################################################
    $tableName = "unapproved_profiles";
    $procedureName = "setUnapprovedOrganizationStatus";
    %updateHash = ("status"=>"status");
    %whereHash = ("organization_id"=>"organization_id");
    @parameterList = ("organization_id MEDIUMINT","status VARCHAR(20)");
    my $updateUnapprovedOrganization = MysqlUtils::generateWriteProcedureFromHash($tableName,$procedureName,\%updateHash,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$updateUnapprovedOrganization\n";
    }
    print OUTPUT "$updateUnapprovedOrganization\n";
    ###################################################
    $tableName = "unapproved_profiles";
    $procedureName = "setUnapprovedIndividualStatus";
    %updateHash = ("status"=>"status");
    %whereHash = ("individual_id"=>"individual_id");
    @parameterList = ("individual_id MEDIUMINT","status VARCHAR(20)");
    my $setUnapprovedIndividualStatus = MysqlUtils::generateWriteProcedureFromHash($tableName,$procedureName,\%updateHash,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$setUnapprovedIndividualStatus\n";
    }
    print OUTPUT "$setUnapprovedIndividualStatus\n";
    ###################################################
    $tableName = "unapproved_profiles";
    $procedureName = "deleteUnapprovedOrganization";
    %whereHash = ("organization_id"=>"organization_id");
    @parameterList = ("organization_id MEDIUMINT");
    my $deleteUnapprovedOrganization = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteUnapprovedOrganization\n";
    }
    print OUTPUT "$deleteUnapprovedOrganization\n";
    ###################################################
    $tableName = "unapproved_profiles";
    $procedureName = "deleteUnapprovedIndividual";
    %whereHash = ("individual_id"=>"individual_id");
    @parameterList = ("individual_id MEDIUMINT");
    my $deleteUnapprovedIndividual = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteUnapprovedIndividual\n";
    }
    print OUTPUT "$deleteUnapprovedIndividual\n";
    ###################################################
    $tableName = "admins";
    $procedureName = "deleteAdmin";
    %whereHash = ("email"=>"email");
    @parameterList = ("email VARCHAR(50)");
    my $deleteAdmin = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteAdmin\n";
    }
    print OUTPUT "$deleteAdmin\n";
    ###################################################
    $tableName = "admins";
    $procedureName = "insertAdmin";
    %insertHash = (
	"email" => "email", 
	"password" => "password",
	"salt" => "salt"
	);
    $modifierString = "";
    @parameterList = (
	"email VARCHAR(50)",
	"password VARCHAR(128)",
	"salt VARCHAR(128)"
	);
    my $insertAdmin = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertAdmin\n";
    }
    print OUTPUT "$insertAdmin\n";
    ###################################################
    $tableName = "bill_votes";
    $procedureName = "updateBillVote";
    %updateHash = ("reddit"=>"reddit",
	           "google"=>"google",
	           "facebook"=>"facebook",
	           "twitter"=>"twitter");
    %whereHash = ("billId"=>"billId");
    @parameterList = ("billId MEDIUMINT(9)","reddit MEDIUMINT(9)","google MEDIUMINT(9)","facebook MEDIUMINT(9)","twitter MEDIUMINT(9)");
    my $updateBillVote = MysqlUtils::generateWriteProcedureFromHash($tableName,$procedureName,\%updateHash,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$updateBillVote\n";
    }
    print OUTPUT "$updateBillVote\n";
    ###################################################
    $tableName = "bill_votes";
    $procedureName = "insertBillVote";
    %insertHash = (
	"billId"=>"billId",
	"reddit"=>"reddit",
	"google"=>"google",
	"facebook"=>"facebook",
	"twitter"=>"twitter"
	);
    $modifierString = "";
    @parameterList = (
	"billId MEDIUMINT(9)",
	"reddit MEDIUMINT(9)",
	"google MEDIUMINT(9)",
	"facebook MEDIUMINT(9)",
	"twitter MEDIUMINT(9)"
	);
    my $insertBillVote = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertBillVote\n";
    }
    print OUTPUT "$insertBillVote\n";
    ###################################################
    $tableName = "comments_bills";
    $procedureName = "updateBillComment";
    %updateHash = ( "user" => "user",
		    "comment"=>"comment",
		    "sub_comment"=>"sub_comment",
		    "comment_post_date"=>"comment_post_date",
		    "sub_comment_post_date"=>"sub_comment_post_date");
    %whereHash = ("id"=>"id");
    @parameterList = ("user MEDIUMINT(9)",
		      "comment VARCHAR(200)",
		      "sub_comment VARCHAR(200)",
		      "comment_post_date DATE",
		      "sub_comment_post_date DATE");
    my $updateBillComment = MysqlUtils::generateWriteProcedureFromHash($tableName,$procedureName,\%updateHash,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$updateBillComment\n";
    }
    print OUTPUT "$updateBillComment\n";
    ###################################################
    $tableName = "comments_bills";
    $procedureName = "insertBillComment";
    %insertHash = ("user" => "user",
		   "comment"=>"comment",
		   "sub_comment"=>"sub_comment",
		   "comment_post_date"=>"comment_post_date",
		   "sub_comment_post_date"=>"sub_comment_post_date");
    $modifierString = "";
    @parameterList = ("user MEDIUMINT(9)",
		      "comment VARCHAR(200)",
		      "sub_comment VARCHAR(200)",
		      "comment_post_date DATE",
		      "sub_comment_post_date DATE");
    my $insertBillComment = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertBillComment\n";
    }
    print OUTPUT "$insertBillComment\n";
    ###################################################
    $tableName = "comments_bill";
    $procedureName = "deleteBillComment";
    %whereHash = ("id"=>"id");
    @parameterList = ("id MEDIUMINT(9)");
    my $deleteBillComment = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteBillComment\n";
    }
    print OUTPUT "$deleteBillComment\n";
    ###################################################
    $tableName = "individuals";
    $procedureName = "insertIndividual";
    %insertHash = (
	"first_name" => "first_name", 
	"last_name" => "last_name", 
	"username" => "username", 
	"birthdate" => "birthdate",
	"gender" => "gender",
	"address" => "address",
	"city" => "city",
	"state" => "state",
	"zip" => "zip",
	"email" => "email",
	"password" => "password",
	"political_affiliation" => "political_affiliation",
	"activated" => "activated",
	"salt" => "salt"
	);
    $modifierString = "";
    @parameterList = (
	"first_name VARCHAR(50)", 
	"last_name VARCHAR(50)",
	"username VARCHAR(30)", 
	"birthdate DATE",
	"gender CHAR(1)", 
	"address VARCHAR(200)", 
	"city VARCHAR(200)", 
	"state VARCHAR(100)", 
	"zip MEDIUMINT",
	"email VARCHAR(128)",
	"password VARCHAR(100)", 
	"political_affiliation VARCHAR(30)", 
	"activated VARCHAR(5)", 
	"salt VARCHAR(128)"
	);
    my $insertIndividual = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertIndividual\n";
    }
    print OUTPUT "$insertIndividual\n";
    #####################################################
    $tableName = "individuals";
    $procedureName = "deleteIndividual";
    %whereHash = ("id"=>"id");
    @parameterList = ("id MEDIUMINT(9)");
    my $deleteIndividual = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteIndividual\n";
    }
    print OUTPUT "$deleteIndividual\n";
    ###################################################
    $tableName = "news";
    $procedureName = "deleteNewsItem";
    %whereHash = ("title"=>"title");
    @parameterList = ("title TEXT");
    my $deleteNewsLink = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteNewsLink\n";
    }
    print OUTPUT "$deleteNewsLink\n";
    ###################################################
    $tableName = "news";
    $procedureName = "insertNewsItem";
    %insertHash = (
	"title" => "title", 
	"news_url" => "news_url", 
	"photo" => "photo", 
	"category" => "category",
	"category_index" => "category_index"
	);
    $modifierString = "";
    @parameterList = (
	"title TEXT",
	"news_url VARCHAR(100)", 
	"photo VARCHAR(50)",
	"category VARCHAR(50)",
	"category_index MEDIUMINT(9)"
	);
    my $insertNewsItem = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertNewsItem\n";
    }
    print OUTPUT "$insertNewsItem\n";
    ###################################################
    $tableName = "organizations";
    $procedureName = "insertOrganization";
    %insertHash = (
	"name" => "name", 
	"address" => "address",
	"city" => "city",
	"state" => "state",
	"zip" => "zip",
	"phone" => "phone",
	"legal_status" => "legal_status",
	"cause_concerns" => "cause_concerns",
	"join_reason" => "join_reason",
	"individual_name" => "individual_name",
	"title_in_organization" => "title_in_organization", 
	"personal_phone" => "personal_phone", 
	"email" => "email",
	"password" => "password",
 	"salt" => "salt",
	"verified" => "verified",
	"signup_date" => "signup_date",
	);
    $modifierString = "";
    @parameterList = (
	"name VARCHAR(50)", 
	"address VARCHAR(200)", 
	"city VARCHAR(200)",
	"state VARCHAR(100)", 
	"zip MEDIUMINT",
	"phone VARCHAR(100)",
	"legal_status VARCHAR(100)", 
	"cause_concerns VARCHAR(30)",
	"join_reason VARCHAR(500)",
	"individual_name VARCHAR(300)", 
	"title_in_organization VARCHAR(300)", 
	"personal_phone VARCHAR(20)", 
	"email VARCHAR(40)", 
	"password VARCHAR(128)", 
	"salt VARCHAR(128)",
	"verified VARCHAR(5)", 
	"signup_date DATE"
	);
    my $insertOrganization = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertOrganization\n";
    }
    print OUTPUT "$insertOrganization\n";
    #####################################################
    $tableName = "organizations";
    $procedureName = "deleteOrganization";
    %whereHash = ("id"=>"id");
    @parameterList = ("id MEDIUMINT(9)");
    my $deleteOrganization = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteOrganization\n";
    }
    print OUTPUT "$deleteOrganization\n";
    #######################################################
    $tableName = "proposals";
    $procedureName = "insertProposal";
    %insertHash = (
	"individual_id" => "individual_id", 
	"name" => "name", 
	"concern" => "concern", 
	"category1" => "category1",
	"category2" => "category2",
	"category3" => "category3",
	"created" => "created",
	"verified" => "verified",
	"description" => "description"
	);
    $modifierString = "";
    @parameterList = (
	"individual_id MEDIUMINT",
	"name VARCHAR(50)", 
	"concern VARCHAR(200)",
	"category1 VARCHAR(100)",
	"category2 VARCHAR(100)", 
	"category3 VARCHAR(100)",
	"created DATE",
	"verified VARCHAR(1)", 
	"description TEXT"
	);
    my $insertProposal = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertProposal\n";
    }
    print OUTPUT "$insertProposal\n";
    ###################################################
    $tableName = "proposals";
    $procedureName = "deleteProposal";
    %whereHash = ("id"=>"id");
    @parameterList = ("id MEDIUMINT(9)");
    my $deleteProposal = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteProposal\n";
    }
    print OUTPUT "$deleteProposal\n";
    ###################################################    
    $tableName = "reported_comments";
    $procedureName = "insertReportedComment";
    %insertHash = (
	"submitted_by" => "submitted_by", 
	"date" => "date", 
	"relevant_bill" => "relevant_bill", 
	"status" => "status"
	);
    $modifierString = "";
    @parameterList = (
	"submitted_by VARCHAR(100)",
	"date DATE", 
	"relevant_bill MEDIUMINT",
	"status VARCHAR(20)"
	);
    my $insertReportedComment = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertReportedComment\n";
    }
    print OUTPUT "$insertReportedComment\n";

    ######################################################
    $tableName = "reported_comments";
    $procedureName = "deleteReportedComment";
    %whereHash = ("id"=>"id");
    @parameterList = ("id MEDIUMINT(9)");
    my $deleteReportedComment = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteReportedComment\n";
    }
    print OUTPUT "$deleteReportedComment\n";
    ###################################################
    $tableName = "representatives";
    $procedureName = "insertRepresentative";
    %insertHash = (
	"name" => "name",
	"state" => "state",
	"url" => "url",
	"email" => "email",
	"phone" => "phone",
	"photo" => "photo",
	"chamber" => "chamber"
	);
    $modifierString = "";
    @parameterList = (
	"name 	varchar(50)",
	"state 	varchar(50)",
	"url 	text",
	"email 	varchar(50)",
	"phone 	varchar(20)",
	"photo 	varchar(60)",
	"chamber varchar(50)"
	);
    my $insertRepresentative = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertRepresentative\n";
    }
    print OUTPUT "$insertRepresentative\n";

    ######################################################
    $tableName = "representatives";
    $procedureName = "deleteRepresentative";
    %whereHash = ("id"=>"id");
    @parameterList = ("id MEDIUMINT(9)");
    my $deleteRepresentative = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteRepresentative\n";
    }
    print OUTPUT "$deleteRepresentative\n";
    ###################################################
    $tableName = "static_pages";
    $procedureName = "insertStaticPage";
    %insertHash = (
	"page_title" => "page_title",
	"text_blob1" => "text_blob1",
	"text_blob2" => "text_blob2",
	"text_blob3" => "text_blob3",
	"text_blob4" => "text_blob4",
	"picture1" => "picture1",
	"picture2" => "picture2",
	"picture3" => "picture3",
	"picture4" => "picture4"
	);
    $modifierString = "";
    @parameterList = (
	"page_title text",
	"text_blob1 text",
	"text_blob2 text",
	"text_blob3 text",
	"text_blob4 text",
	"picture1 varchar(200)",
	"picture2 varchar(200)",
	"picture3 varchar(200)",
	"picture4 varchar(200)"
	);
    my $insertStaticPage = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertStaticPage\n";
    }
    print OUTPUT "$insertStaticPage\n";

    ######################################################
    $tableName = "static_pages";
    $procedureName = "deleteStaticPage";
    %whereHash = ("id"=>"id");
    @parameterList = ("id MEDIUMINT(9)");
    my $deleteStaticPage = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteStaticPage\n";
    }
    print OUTPUT "$deleteStaticPage\n";
    ###################################################
    $tableName = "user_votes";
    $procedureName = "insertUserVote";
    %insertHash = (
	"billId" => "billId",
	"user_id" => "user_id",
	"picture1" => "picture1",
	"organization_id" => "organization_id",
	"vote" => "vote",
	"date" => "date"
	);
    $modifierString = "";
    @parameterList = (
	"billId MEDIUMINT(9)",
	"user_id MEDIUMINT(9)",
	"organization_id MEDIUMINT(9)",
	"vote varchar(200)",
	"date DATE"
	);
    my $insertUserVote = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertUserVote\n";
    }
    print OUTPUT "$insertUserVote\n";

    ######################################################
    $tableName = "user_votes";
    $procedureName = "deleteUserVote";
    %whereHash = ("id"=>"id");
    @parameterList = ("id MEDIUMINT(9)");
    my $deleteUserVote = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteUserVote\n";
    }
    print OUTPUT "$deleteUserVote\n";
    ###################################################
    $tableName = "wall_of_america";
    $procedureName = "insertWallOfAmerica";
    %insertHash = (
	"user" => "user", 
	"dream" => "dream", 
	"wish" => "wish", 
	"date" => "date"
	);
    $modifierString = "";
    @parameterList = (
	"user MEDIUMINT",
	"date DATE", 
	"dream VARCHAR(200)",
	"wish VARCHAR(200)"
	);
    my $insertWallOfAmerica = MysqlUtils::generateInsertProcedureFromHash($tableName,$procedureName,\%insertHash,$modifierString,\@parameterList);
    if($debug == 1){
	print "Writing -->$insertWallOfAmerica\n";
    }
    print OUTPUT "$insertWallOfAmerica\n";
    #######################################################
    $tableName = "wall_of_america";
    $procedureName = "deleteWallOfAmericaEntry";
    %whereHash = ("id"=>"id");
    @parameterList = ("id MEDIUMINT(9)");
    my $deleteWallOfAmericaEntry = MysqlUtils::generateDeleteProcedureFromHash($tableName,$procedureName,\%whereHash,\@parameterList);
    if($debug == 1){
	print "Writing -->$deleteWallOfAmericaEntry\n";
    }
    print OUTPUT "$deleteWallOfAmericaEntry\n";
    ###################################################
    print OUTPUT 'DELIMITER ;'."\n";

    

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

    my $billBufferColumns = "id, official_title, bill_type, status, updated_at, status_at, bill_id, subjects_top_term, enacted_as, number, short_title, introduced_at, congress, by_request, popular_title, bill_html, history, related_bills,bill_json,bill_xml,subjects_top_term";
    my $sql = "SELECT $billBufferColumns from congress_github_bills;";
    if($debug == 1){
	print "Execute -->$sql\n";
    }
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "SQL Error: $DBI::errstr\n"; 
    while(my @row = $sth->fetchrow_array){
	my ($id, $official_title, $bill_type, $status, $updated_at, $status_at, $bill_id, $subjects_top_term, $enacted_as, $number, $short_title, $introduced_at, $congress, $by_request, $popular_title, $localHtml, $history, $related_bills,$localJson,$localXml,$subject) = @row;
	if (defined($localHtml)){
	    $localHtml =~ s/.*(initialData.*)$/$1/;
	}
	if (defined($localJson)){
	    $localJson =~ s/.*(initialData.*)$/$1/;
	}
	if (defined($localXml)){
	    $localXml =~ s/.*(initialData.*)$/$1/;
	}
	my @insertBillColumns = ("title","status","url","code","open","local_html","local_json","local_xml","is_appropiation_bill","is_large_bill","subject");
	my @insertBillData = ($official_title,$status,"NULL",$bill_id,"NULL",$localHtml,$localJson,$localXml,"n","n",$subject);
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

sub writeTestData{
    my $outputFile = "loadTestData.db";
    if(-e $outputFile){
	unlink $outputFile || die "Couldn't delete $outputFile $!\n";
    }
    open(OUTPUT,">$outputFile") || die "Couldn't open $outputFile. SQL Error $DBI::errstr\n";

    print OUTPUT "CALL insertAdmin('test_email','test_password','test_salt');";
    print OUTPUT "CALL insertBillComment (1,'test_comment','test_sub_comment',NOW(),NOW());"; 	
    print OUTPUT "CALL insertBillVote (1,2,3,4,5);"; 	
    print OUTPUT "CALL insertIndividual ('test_first','test_last','test_name',NOW(),'m','test_address','test_city','test_state',1,'test_email','test_pass','test_affiliation','test','test_salt');"; 	 	
    print OUTPUT "CALL insertNewsItem ('test_title','test_url','test_photo','test_category',1); "; 	
    print OUTPUT "insertProposal ";
    print OUTPUT "CALL insertReportedComment('test_submitter',CURDATE(),-1,'test_status');\n"; 	
    print OUTPUT "CALL insertWallOfAmerica ('1',CURDATE(),'test_dream','test_wish');"; 	
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
	my @insertRepresentativesData = ($firstname . " ".$lastname,$state,$website,$oc_email,$phone,$bioguide_id,$congress_office);
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
    my $enableLogging = 0;
    my $dbh = $_[0];
    my $outputFile = $_[1];
    my $storedProceduresFile = "stored_procedures.db";
    if(-e $outputFile){
	unlink $outputFile || die "Couldn't remove $outputFile $!\n";
    }
    if(-e $storedProceduresFile){
	unlink $storedProceduresFile || die "Couldn't remove $storedProceduresFile $!\n";
    }
    if(-e "loadProduction.log"){
	unlink "loadProduction.log" || die "Couldn't remove loadProduction.log $!\n";
    }
    open(OUTPUT,">>$outputFile") || die "Couldn't open $outputFile. $!\n"; 
    if($enableLogging == 1){
	print OUTPUT "\\W\n";
	print OUTPUT "tee loadProduction.log;\n";
    }
    print OUTPUT "use fourthbranch;\n"; 
    &writeCreateTables($outputFile);
    &writeStoredProcedures($storedProceduresFile);
    &extractBills($dbh,$outputFile);
    &extractRelatedBills($dbh,$outputFile);
    &extractBillVotes($dbh,$outputFile);
    &extractRepresentatives($dbh,$outputFile);
    &writeTestData();
    if($enableLogging == 1){
	print OUTPUT "notee;\n";
	print OUTPUT "\\w\n";
    }
    # -Generate bill history tablefdxzzzd
    # - Generate Actions table
    # - Generate sponsor table
    # - Generate Amends Bill table
    # - Insert Amendments
}

1;
