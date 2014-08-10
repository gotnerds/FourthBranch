#!/usr/bin/perl -w
###!C:/xampp/perl/bin/perl.exe

use warnings;
use CGI::Carp 'fatalsToBrowser';
use CGI qw/:standard/;
use Cwd qw(cwd abs_path);
use File::Basename 'dirname';
use JSON::PP qw(encode_json decode_json);
use lib dirname(abs_path $0);
use strict;

# Individual Users
my $CREATE_INDIVIDUAL_USERS_TABLE ="create table individuals 
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
);";

# Organization Users
my $CREATE_ORGANIZATION_USERS_TABLE ="create table organizations 
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
  PRIMARY KEY (id)
);";

# Admin Users
my $CREATE_ADMIN_USERS_TABLE ="create table admins 
( id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,
  email VARCHAR(50) NOT NULL UNIQUE, 
  password VARCHAR(200), 
  PRIMARY KEY (id)
)";



# Normal Bills
my $CREATE_NORMAL_BILL_TABLE = "create table bills 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
 title VARCHAR(300) NOT NULL UNIQUE, 
 state VARCHAR(50), 
 url VARCHAR(500), 
 code VARCHAR(50),
 open VARCHAR(5),
 PRIMARY KEY(id)
)";

# Large Bills Table
my $CREATE_LARGE_BILL_TABLE = "create table large_bills 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,
 title VARCHAR(300) NOT NULL UNIQUE, 
 state VARCHAR(50), 
 url VARCHAR(500), 
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
)";

# Appropriation Bills Table
my $CREATE_APPROPRIATION_BILL_TABLE = "create table appropriation_bills 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,
 title VARCHAR(300) NOT NULL UNIQUE, 
 state VARCHAR(50), 
 url VARCHAR(500), 
 code VARCHAR(50),
 open VARCHAR(5),
 num_sections MEDIUMINT,
 budget MEDIUMINT,
 num_sections MEDIUMINT,
 section_name MEDIUMINT,
 section_allocation MEDIUMINT,
 num_objects MEDIUMINT,
 object_name MEDIUMINT,
 object_allocation MEDIUMINT,
 PRIMARY KEY(id)
)";
 
#
# Representatives
my $CREATE_REPRESENTATIVES_TABLE = "create table representatives 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
 name VARCHAR(50) NOT NULL UNIQUE, 
 state VARCHAR(50), 
 url VARCHAR(500), 
 email VARCHAR(50),
 phone VARCHAR(5),
 photo VARCHAR(60),
 chamber VARCHAR(10), 
 PRIMARY KEY(id)
)";

# Bill Vote 
my $CREATE_BILL_VOTE_TABLE = "create table bill_votes 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
 billId MEDIUMINT NOT NULL, 
 reddit MEDIUMINT , 
 google MEDIUMINT, 
 facebook MEDIUMINT,
 twitter MEDIUMINT,
 PRIMARY KEY(id)
)";

# User Votes 
my $CREATE_USER_VOTES_TABLE = "create table user_votes 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT, 
 billId MEDIUMINT NOT NULL, 
 user MEDIUMINT , 
 vote VARCHAR(200), 
 date DATE,
 PRIMARY KEY(id)
)";
 
# WallOfAmerica
my $CREATE_WALL_OF_AMERICA_TABLE = "create table wall_of_america 
(id MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT,  
 user MEDIUMINT , 
 dream VARCHAR(200),
 wish VARCHAR(200), 
 date DATE,
 PRIMARY KEY(id)
)";


my @tables = ( $CREATE_INDIVIDUAL_USERS_TABLE, $CREATE_ORGANIZATION_USERS_TABLE, $CREATE_ADMIN_USERS_TABLE,$CREATE_BILL_TABLE,$CREATE_REPRESENTATIVES_TABLE,$CREATE_WALL_OF_AMERICA_TABLE,$CREATE_BILL_VOTES_TABLE,$CREATE_USER_VOTES_TABLE,$CREATE_LARGE_BILLS_TABLE,$CREATE_APPROPRIATION_BILLS_TABLE);

my @table_names = ("individuals", "organizations","admins","bills","representatives","bill_votes","user_votes","wall_of_america","large_bills","appropriation_bills");
# TODO District Search

use DBI;
###########################
# Main
my $VERSION_NUMBER = 1.0;
my $curDir = cwd();
my $cgiQuery = CGI->new();
my $hostname = `hostname`;
my $dbh;
if($hostname =~ /spooky-Laptop/){
    $dbh = DBI->connect('dbi:mysql:fourthbranch;'."mysql_read_default_file=$curDir/mysql.conf",'root','root') or die "Connection Error: $DBI::errstr\n";
}
elsif($^O =~ /MSWin32/){
     $dbh = DBI->connect('dbi:mysql:database=fourthbranch;host=127.0.0.1:3306;'."mysql_read_default_file=$curDir/mysql.conf",'root','') or die "Connection Error: $DBI::errstr\n";   
}
else{
    $dbh = DBI->connect('DBI:mysql:database=fourthbranch;host=fourthbranch.db.9192271.hostedresource.com;' ."mysql_read_default_file=$curDir/mysql.conf",'fourthbranch','G0tnerds!') or die "Connection Error: $DBI::errstr\n";
}

#print header('text/html');
#print start_html('goball_api');
#&printEnvironmentVariables();

&commandLineToHtmlEncoded();
print "[";# Start the json array
my $function = param('run');
if($function eq 'version'){
    print $VERSION_NUMBER
}
elsif($function eq 'loginOrganization'){
    my $email = param('email');
    my $password = param('password');
    if(defined($email) && defined($password)){
	my $result = &loginOrganization($email,$password);
	my %result = ('successful' => 'false');
	if($result == 1){
	    $result{'successful'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($email,$password);
    }
}
elsif($function eq 'loginIndividual'){
    my $email = param('email');
    my $password = param('password');
    if(defined($email) && defined($password)){
	my $result = &loginIndividual($email,$password);
	my %result = ('successful' => 'false');
	if($result == 1){
	    $result{'successful'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($email,$password);
    }
}
elsif($function eq 'addAdminUser'){
    my $email = param('email');
    my $password = param('password');
    if(defined($email) && defined($password)){
	my $result = &addAdminUser($email,$password);
	my %result = ('successful' => 'false');
	if($result == 1){
	    $result{'successful'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($email,$password);
    }
}
elsif($function eq 'removeAdminUser'){
    my $email = param('email');
    if(defined($email)){
	my $result = &removeAdminUser($email);
	my %result = ('successful' => 'false');
	if($result == 1){
	    $result{'successful'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($email);
    }
}
elsif($function eq 'addRepresentative'){
    my $name = param('name');
    my $state = param('state');
    my $url = param('url');
    my $email = param('email');
    my $phone = param('phone');
    my $chamber = param('chamber');
    if(defined($name) && defined($state) && defined($url) && defined($email) && defined ($phone) && defined($chamber)){
	my $result = &addRepresentative($name,$state,$url,$email,$phone);
	my %result = ('successful' => 'false');
	if($result == 1){
	    $result{'successful'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($name,$state,$url,$email,$phone,$chamber);
    }
}
elsif($function eq 'removeRepresentative'){
    my $email = param('email');
    if(defined($email)){
	my $result = &removeRepresentative($email);
	my %result = ('successful' => 'false');
	if($result == 1){
	    $result{'successful'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($email);
    }
}
elsif($function eq 'addBill'){
    my $title = param('title');
    my $state = param('state');
    my $url = param('url');
    my $code = param('code');
    if(defined($title) && defined($state) && defined($url) && defined($code)){
	my $result = &addBill($title,$state,$url,$code);
	my %result = ('successful' => 'false');
	if($result == 1){
	    $result{'successful'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($title,$state,$url,$code);
    }
}
elsif($function eq 'closeBill'){
    my $code = param('code');
    my $open = param('open');
    if(defined($code) && defined($open)){
	my $result = &closeBill($code,$open);
	my %result = ('successful' => 'false');
	if($result == 1){
	    $result{'successful'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($code,$open);
    }
}
elsif($function eq 'loginAdmin'){
    my $email = param('email');
    my $password = param('password');
    if(defined($email) && defined($password)){
	my $result = &loginAdmin($email,$password);
	my %result = ('successful' => 'false');
	if($result == 1){
	    $result{'successful'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($email,$password);
    }
}
elsif($function eq 'setActivatedIndividual'){
    my $email = param('email');
    my $activate = param('activate');
    if(defined($email) && defined($activate)){
	if($activate ne "true" && $activate ne "false"){
	    my %result = ('successful' => 'false');
	    print encode_json(\%result);
	}
	else{
	    my $result = &setActivatedIndividual($email,$activate);
	    my %result = ('successful' => 'false');
	    if($result == 1){
		$result{'successful'} = 'true';
	    }
	    print encode_json(\%result);
	}
    }
    else{
	&paramCheck($email,$activate);
    }
}
elsif($function eq 'getActivatedIndividual'){
    my $email = param('email');
    if(defined($email)){
	my $activated = &getActivatedIndividual($email);
	my %result = ('activated' => 'false');
	if($activated == 1){
	    $result{'activated'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($email);
    }
}
elsif($function eq 'setVerifiedOrganization'){
    my $email = param('email');
    my $verified = param('verified');
    if(defined($email) && defined($verified)){
	if($verified ne "true" && $verified ne "false"){
	    my %result = ('successful' => 'false');
	    print encode_json(\%result);
	}
	else{
	    my $result = &setVerifiedOrganization($email,$verified);
	    my %result = ('successful' => 'false');
	    if($result == 1){
		$result{'successful'} = 'true';
	    }
	    print encode_json(\%result);
	}
    }
    else{
	&paramCheck($email,$verified);
    }
}
elsif($function eq 'getVerifiedOrganization'){
    my $email = param('email');
    if(defined($email)){
	my $verified = &getVerifiedOrganization($email);
	my %result = ('verified' => 'false');
	if($verified == 1){
	    $result{'verified'} = 'true';
	}
	print encode_json(\%result);
    }
    else{
	&paramCheck($email);
    }
}

elsif($function eq 'addOrganization'){
# Organization Users
# --- Legal Status
# --- cause_concerns
# --- join_reason
    my $name = param('name');
    my $address = param('address');
    my $city = param('city');
    my $state = param('state');
    my $zip = param('zip');
    my $phone = param('phone');
    my $legal_status = param('legalstatus');
    my $cause_concerns = param('cause');
    my $join_reason = param('joinreason');
    my $individual_name = param('individualname');
    my $title_in_organization = param('titleorganization');
    my $personal_phone = param('personalphone');
    my $email = param('email');
    my $password = param('password');
    if(defined($name) && defined($address) && defined($city) && defined($state) && defined($zip) && defined($phone) && defined($legal_status) && defined($cause_concerns) && defined($join_reason) && defined($individual_name) && defined($title_in_organization) && defined($personal_phone) && defined($email) && defined($password)){
	my $organizationExists = &getOrganizationNameExists($name);
	if($organizationExists == 0){
	    my $result = &addOrganization($name,$address,$city,$state,$zip,$phone,$legal_status,$cause_concerns, $join_reason,$individual_name,$title_in_organization,$personal_phone,$email,$password);
	    my %resultOut = ('successful' => 'false');
	    if($result == 1){
		$resultOut{'successful'} = 'true';
	    }
	    print encode_json(\%resultOut);
	}
	else{
	    my %result = ('successful' => 'false',
			  'name_taken' => 'true');
	    print encode_json(\%result);
	}
	
    }
    else{
	&paramCheck($name,$address,$city,$state,$zip,$phone,$legal_status,$cause_concerns,$join_reason, $individual_name,$title_in_organization,$personal_phone,$email,$password);
    }
}
elsif($function eq 'addIndividual'){

    my $first = param('first'); 
    my $last = param('last');
    my $username = param('username');
    my $birthDate = param('birthdate');
    my $gender = param('gender');
    my $address = param('address');
    my $city = param('city');
    my $state = param('state');
    my $zip = param('zip');
    my $email = param('email');
    my $password = param('password');
    my $affiliation = param('affiliation');
    if(defined($first) && defined($last) && defined($username) && defined($birthDate) && defined($gender) && defined($address) && defined($city) && defined($state) && defined($zip) && defined($email) && defined($password) && defined($affiliation)){
	my $userNameExists = &getUserNameExists($username);
	if($userNameExists == 0){
	    my $result = &addIndividual($first,$last,$username,$birthDate,$gender,$address,$city,$state,$zip,$email,$password, $affiliation);
	    my %resultOut = ('successful' => 'false');
	    if($result == 1){
		$resultOut{'successful'} = 'true';
	    }
	    print encode_json(\%resultOut);
	}
	else{
	    my %result = ('successful' => 'false',
			  'name_taken' => 'true');
	    print encode_json(\%result);
	}
    }
    else{
	&paramCheck($first,$last,$username,$birthDate,$gender,$address,$city,$state,$zip,$email,$password,$affiliation);
    }
}
elsif($function eq 'getIndividualNameExists'){
    my $userName = param('name');
    if(!($userName == undef)){
	&getIndividualNameExists($userName);
    }
}
elsif($function eq 'getIndividualById'){
    my $userId = param('individualid');
    if(!($userId == undef)){
	&getIndividualById($userId);
    }
}
elsif($function eq 'getOrganizationNameExists'){
    my $userName = param('name');
    if(defined($userName)){
	&getOrganizationNameExists($userName);
    }
}
elsif($function eq 'getOrganizationById'){
    my $userId = param('organizationid');
    if(defined($userId)){
	&getOrganizationById($userId);
    }
}
elsif($function eq 'install'){
    &dropBackendTables();
    &createBackendTables();
}
#&loadTestData();

print "]"; # print end of json array
#print end_html();
$dbh->disconnect;
########################
########################
# Functions
sub createBackendTables{
    for my $index (@tables){
	my $sql = $index; 
	print "Execute -->$sql\n\n";
	my $sth = $dbh->prepare($sql);
	$sth->execute or die "Create Backend Tables: SQL Error: $DBI::errstr\n";
    }
}

sub dropBackendTables{
    for my $table (@table_names){
	my $sql = "DROP TABLE IF EXISTS ".$table.";";
	print "Execute -->$sql\n\n";
	my $sth = $dbh->prepare($sql);
	$sth->execute or die "Drop Backend Tables: SQL Error: $DBI::errstr\n"; 
    }
    print "Tables dropped\n";
}

sub addOrganization{
    my $name = $_[0];
    my $address = $_[1];
    my $city = $_[2];
    my $state = $_[3];
    my $zip = $_[4];
    my $phone = $_[5];
    my $legal_status = $_[6];
    my $cause_concerns = $_[7];
    my $join_reason = $_[8];
    my $individual_name = $_[9];
    my $title_in_organization = $_[10];
    my $personal_phone = $_[11];
    my $email = $_[12];
    my $password = $_[13];
    my $verified = 'false';
    my $sql = "INSERT INTO organizations (name, address, city, state, zip,phone,legal_status, cause_concerns,join_reason,individual_name,title_in_organization, personal_phone, email,password,verified) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    my $sth = $dbh->prepare($sql);
    $sth->execute($name,$address,$city,$state,$zip,$phone,$legal_status,$cause_concerns,$join_reason,$individual_name,$title_in_organization,$personal_phone,$email,$password,$verified) or  warn "SQL Error: $DBI::errstr\n" && return 'false';
    return 'true';
}

sub addBill{
    my $title = $_[0];
    my $state = $_[1];
    my $url = $_[2];
    my $code = $_[3];
    my $open = 'true';
    my $sql = "INSERT INTO bills (title,state,url,code,open) VALUES (?,?,?,?,?);";
    my $sth = $dbh->prepare($sql);
    $sth->execute($title,$state,$url,$code,$open) or warn "SQL Error: $DBI::errstr\n" && return 0;
    return 1;
}

sub closeBill{
    my $code = $_[0];
    my $open = $_[1];
    my $sql = "UPDATE bills SET open=? where code=?);";
    my $sth = $dbh->prepare($sql);
    $sth->execute($open,$code) or warn "SQL Error: $DBI::errstr\n" && return 0;
    return 1;

}

sub addRepresentative{
    my $name = $_[0];
    my $state = $_[1];
    my $url = $_[2];
    my $email = $_[3];
    my $phone = $_[4];
    my $chamber = $_[5];
    my $sql = "INSERT INTO representatives (name, chamber,state,url ,email,phone) VALUES (?,?,?,?,?,?);";
    my $sth = $dbh->prepare($sql);
    $sth->execute($name,$state,$url,$email,$phone,$chamber) or warn "SQL Error: $DBI::errstr\n" && return 0;
    return 1;
}

sub removeRepresentative{
    my $email = $_[0];
    my $sql = "DELETE FROM representatives where email=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($email) or warn "SQL Error: $DBI::errstr\n" && return 0;
    return 1;
}

sub addAdminUser{
    my $email = $_[0];
    my $password = $_[1];
    my $sql = "INSERT INTO admins (email, password) VALUES (?,?);";
    my $sth = $dbh->prepare($sql);
    $sth->execute($email,$password) or warn "SQL Error: $DBI::errstr\n" && return 0;
    return 1;
}

sub removeAdminUser{
    my $email = $_[0];
    my $sql = "DELETE FROM admins where email=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($email) or warn "SQL Error: $DBI::errstr\n" && return 0;
    return 1;
}

sub addIndividual{
    my $first = $_[0];
    my $last = $_[1];
    my $username = $_[2];
    my $birthDate = $_[3];
    my $gender = $_[4];
    my $address = $_[5];
    my $city = $_[6];
    my $state = $_[7];
    my $zip = $_[8];
    my $email = $_[9];
    my $password = $_[10];
    my $affiliation = $_[11];
    my $activated = 'true';
    my $sql = "INSERT INTO individuals (first_name,last_name,username, birthdate,gender, address , city, state, zip ,email,password, political_affiliation, activated) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
    my $sth = $dbh->prepare($sql);
    $sth->execute($first,$last,$username,$birthDate,$gender,$address,$city,$state, $zip,$email,$password,$affiliation,$activated) or warn "SQL Error: $DBI::errstr\n" && return 0;
    return 1;
}


sub getOrganizationNameExists{
    my $name = $_[0];
    my $columns = "address";
    my $sql = "SELECT ".$columns." FROM organizations where name=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($name) or die "SQL Error: $DBI::errstr\n";
    my $rows_retrieved = $sth->rows;
    my @row = $sth->fetchrow_array();
    $sth->finish();
    if(@row != 0){
	return 1;
    }
    return 0;
}


sub getUserNameExists{
    my $name = $_[0];
    my $columns = "address";
    my $sql = "SELECT ".$columns." FROM individuals where username=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($name) or die "SQL Error: $DBI::errstr\n";
    my $rows_retrieved = $sth->rows;
    my @row = $sth->fetchrow_array();
    $sth->finish();
    if(@row != 0){
	return 1;
    }
    return 0;
}

sub getOrganizationById{
    my $id = $_[0];
    my $columns = "name, address, city, state, zip,phone,legal_status, cause_concerns,join_reason";
    my $sql = "SELECT ".$columns." FROM organizations where id=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($id) or die "SQL Error: $DBI::errstr\n";
    my $rows_retrieved = $sth->rows;
    my $printRowBreak = 0;
    while(my @row = $sth->fetchrow_array){
	if($printRowBreak == 1){
	    print ","
	}
	$printRowBreak = 1;
	my ($name, $address, $city, $state, $zip,$phone,$legal_status, $cause_concerns,$join_reason) = @row;
	my %result = ('name' => $name,
		   'address' => $address,
		   'city' => $city,
		   'state' => $state,
		   'zip' => $zip,
	           'phone' => $phone,
	           'legalstatus' => $legal_status,
	           'cause_concerns' => $cause_concerns,
	           'join_reason' => $join_reason);
	#print encode_json(\%result);
    }   
}

sub loginOrganization{
    my $email = $_[0];
    my $password = $_[1];
    my $sql = "SELECT password FROM organizations where email=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($email) or die "SQL Error: $DBI::errstr\n";
    my $rows_retrieved = $sth->rows;
    if($rows_retrieved < 1){
	return 0;
    }
    my @row = $sth->fetchrow_array;
    my $passwordLookup = $row[0];
    if($passwordLookup eq $password){
	return 1;
    }
    return 0;
}
sub setVerifiedOrganization{
    my $email = $_[0];
    my $verified = $_[1];
    my $sql = "UPDATE organizations SET verified=? where email=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($verified,$email) or warn "SQL Error: $DBI::errstr\n" && return 0;
    return 1;
}

sub getVerifiedOrganization{
    my $email = $_[0];
    my $sql = "SELECT verified FROM organizations where email=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($email) or warn "SQL Error: $DBI::errstr\n" && return 0;
    my $rows_retrieved = $sth->rows;
    if($rows_retrieved < 1){
	return 0;
    }
    my @row = $sth->fetchrow_array;
    my $verified = $row[0];
    if($verified eq 'true'){
	return 1;
    }
    return 0;
}

sub setActivatedIndividual{
    my $email = $_[0];
    my $activated = $_[1];
    my $sql = "UPDATE individuals SET activated=? where email=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($activated,$email) or warn "SQL Error: $DBI::errstr\n" && return 0;
    return 1;
}

sub getActivatedIndividual{
    my $email = $_[0];
    my $sql = "SELECT activated FROM individuals where email=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($email) or warn "SQL Error: $DBI::errstr\n" && return 0;
    my $rows_retrieved = $sth->rows;
    if($rows_retrieved < 1){
	return 0;
    }
    my @row = $sth->fetchrow_array;
    my $activated = $row[0];
    if($activated eq 'true'){
	return 1;
    }
    return 0;
}
sub loginIndividual{
    my $email = $_[0];
    my $password = $_[1];
    my $sql = "SELECT password FROM individuals where email=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($email) or die "SQL Error: $DBI::errstr\n";
    my $rows_retrieved = $sth->rows;
    if($rows_retrieved < 1){
	return 0;
    }
    my @row = $sth->fetchrow_array;
    my $passwordLookup = $row[0];
    if($passwordLookup eq $password){
	return 1;
    }
    return 0;
}

sub loginAdmin{
    my $email = $_[0];
    my $password = $_[1];
    my $sql = "SELECT password FROM admins where email=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($email) or die "SQL Error: $DBI::errstr\n";
    my $rows_retrieved = $sth->rows;
    if($rows_retrieved < 1){
	return 0;
    }
    my @row = $sth->fetchrow_array;
    my $passwordLookup = $row[0];
    if($passwordLookup eq $password){
	return 1;
    }
    return 0;
}

sub getIndividualById{
    my $id = $_[0];
    my $columns = "first_name,last_name,username, birthdate,gender, address , city, state, zip ,email,password, political_affiliation";
    my $sql = "SELECT ".$columns." FROM organizations where id=?;";
    my $sth = $dbh->prepare($sql);
    $sth->execute($id) or die "getIndividualById: SQL Error: $DBI::errstr\n";
    my $rows_retrieved = $sth->rows;
    my $printRowBreak = 0;
    while(my @row = $sth->fetchrow_array){
	if($printRowBreak == 1){
	    print ","
	}
	$printRowBreak = 1;
	my ($first_name,$last_name,$username, $birthdate,$gender, $address , $city, $state, $zip ,$email,$password, $political_affiliation) = @row;
	my %result = ('first_name' => $first_name,
		      'last_name' => $last_name,
		      'username' => $username,
		      'birthdate' => $birthdate,
		      'gender' => $gender,
		      'address' => $address ,
		      'city' => $city,
		      'state' => $state,
		      'zip' => $zip ,
		      'email' => $email,
		      'password' => $password, 
		      'affiliation' => $political_affiliation);
	#print encode_json(\%result);
    }   
}



sub commandLineToHtmlEncoded{
    for(my $index=0; $index<@ARGV;$index++){
	if($ARGV[$index] =~ /(.*)=(.*)/){
	    my $key = $1;
	    my $value = $2;
	    $value =~ s/'"//g;
	    $cgiQuery->param(-name=>"$key",-value=>"$value");
	}
    }
}
sub loadTestData{
    my $curDir = cwd();
    my @tableFiles = (
	[$curDir."/testData/parks.csv","parks"],
	[$curDir."/testData/users.csv","users"],
	[$curDir."/testData/forum.csv","forum"],
	[$curDir."/testData/friends.csv","friends"],
	[$curDir."/testData/pickup_games.csv","pickup_games"],
	[$curDir."/testData/reviews.csv","reviews"]
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


sub printEnvironmentVariables{
    print "<pre>\n";

    foreach my $key (sort keys(%ENV)) {
	print "$key = $ENV{$key}<p>";
    }
    print "</pre>\n";
}

sub paramCheck{
    my $index = 0;
    foreach my $param (@_){
	if(!defined($param)){
	    print "$index is not defined";
	}
	$index++;
    }
}
