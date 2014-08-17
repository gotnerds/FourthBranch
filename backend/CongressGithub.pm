#!/usr/bin/perl 
package CongressGithub;
use strict;
use warnings; 
use Cwd qw(cwd abs_path);
use JSON::PP qw(decode_json encode_json);
use DBI;
use CGI::Carp 'fatalsToBrowser';
use vars qw($VERSION @ISA @EXPORT @EXPORT_OK %EXPORT_TAGS);



$VERSION     = 1.00;
@ISA         = qw(Exporter);
@EXPORT      = qw(loadBills);
@EXPORT_OK   = qw(loadBills);
%EXPORT_TAGS = ( DEFAULT => [qw(&loadBills)]);

my $CURRENT_DIRECTORY = cwd();

sub generateCreateString{
    my $tableName = $_[0];
    my @columns = @{$_[1]};
    my @types = @{$_[2]};
    my $columnsSize = @columns;
    my $typesSize = @types;
    if($columnsSize != $typesSize){
	print "size mismatch in generate create string\n";
	exit();
    }
    my $createString = "";
    for(my $index=0; $index<$columnsSize; $index++){
	my $append = $columns[$index]." ";
	$append .= $types[$index];
	if($index+1 != $columnsSize){
	    $append .= ",";
	}
	$createString .= $append;
    }
    $createString = "create table $tableName".
	            "( id MEDIUMINT NOT NULL ".
		    "UNIQUE AUTO_INCREMENT, ".
		    "$createString,PRIMARY KEY (id));";
    return $createString;
}

sub generateInsertStringFromHash{
    my $debug = 0;
    my $tableName = $_[0];
    my @columns = @{$_[1]};
    my $columnSize = @columns;
    my %hash = %{$_[2]};

    my $insertString = " INSERT INTO $tableName (";
    for(my $index = 0; $index < $columnSize; $index++){
       	$insertString .= $columns[$index];
	if($index+1 != $columnSize){
	    $insertString .= ",";
	}
    }
    $insertString .= ") VALUES (";
    
    for(my $index=0; $index < $columnSize; $index++){
	my $key = $columns[$index];
	if($debug == 1){
	    $insertString .="\n$index :";
	}
	if(defined($hash{$key})){
	    my $santized = $hash{$key};
	    $santized =~ s/"/\\"/g;
	    $insertString .= " \"${santized}\" ";
	}
	else {
	    $insertString .= " NULL ";
	}
	if($index+1 != $columnSize){
	    $insertString .= ",";
	}
    }
    $insertString .= ");";
    return $insertString;
}

sub generateInsertStringFromArray{
    my $debug = 0;
    my $tableName = $_[0];
    my @columns = @{$_[1]};
    my $columnSize = @columns;
    my @array = @{$_[2]};

    my $insertString = " INSERT INTO $tableName (";
    for(my $index = 0; $index < $columnSize; $index++){
       	$insertString .= $columns[$index];
	if($index+1 != $columnSize){
	    $insertString .= ",";
	}
    }
    $insertString .= ") VALUES (";
    
    for(my $index=0; $index < $columnSize; $index++){
	if($debug == 1){
	    $insertString .="\n$index :";
	}
	my $santized = $array[$index];

	$santized =~ s/"/\\"/g;
	$insertString .= " \"${santized}\" ";
	if($index+1 != $columnSize){
	    $insertString .= ",";
	}
    }
    $insertString .= ");";
    return $insertString;
}

sub loadCongressGithubBills{
    print "Installing Congress github bills. This can take like 10 minutes\n";
    my $debug = 0;
    my $dbh = $_[0];
    if(!defined($dbh)){
	print "Undefined DBH !!!\n";
	exit();
    }
    my $tableName = "congress_github_bills";
    my @columns = ("official_title","bill_type","status","updated_at","status_at","bill_id","subjects_top_term","enacted_as","number","short_title","introduced_at","congress","by_request","popular_title");

    my @columnTypes = ("VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)");

    my $columnsSize = @columns;
    my $typesSize = @columnTypes;
    
    if($columnsSize != $typesSize){
	warn("Size mismatch in loadBills");
	return;
    }

    # Drop table
    my $sql = "DROP TABLE IF EXISTS ".$tableName.";";
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "Drop Backend Tables: SQL Error: $DBI::errstr\n";
    
    # Create Table
    $sql = &generateCreateString($tableName,\@columns,\@columnTypes);
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    $sth = $dbh->prepare($sql);
    $sth->execute or die "Failed to create table; $DBI::errstr\n";

    # Populate Tables
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
	my $hashRef = decode_json($inputFile);
	my %bill = %$hashRef;
	my $insertString = &generateInsertStringFromHash($tableName,\@columns,\%bill);
	if($debug == 1){
	    print "Execute -->$insertString\n\n";
	}
	$sth = $dbh->prepare($insertString);
	$sth->execute or warn "Failed to insert Bill($sql) $DBI::errstr\n";
    }
}
sub loadCongressGithubVotes{
    print "Installing Congress github votes.\n";
    my $debug = 0;
    my $dbh = $_[0];
    if(!defined($dbh)){
	print "Undefined DBH !!!\n";
	exit();
    }
    my $tableName = "congress_github_votes";
    my @columns = ("vote_id","bill","date","votes","question","result");

    my @columnTypes = ("VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)");

    my $columnsSize = @columns;
    my $typesSize = @columnTypes;
    
    if($columnsSize != $typesSize){
	warn("Size mismatch in loadVotes");
	exit();
    }

    # Drop table
    my $sql = "DROP TABLE IF EXISTS ".$tableName.";";
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "Drop Backend Tables: SQL Error: $DBI::errstr\n";
    
    # Create Table
    $sql = &generateCreateString($tableName,\@columns,\@columnTypes);
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    $sth = $dbh->prepare($sql);
    $sth->execute or die "Failed to create table; $DBI::errstr\n";

    # Populate Tables
    opendir(VOTES_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/votes") || die "Couldn't open the votes directory. $!";
    my @voteTypes;
    while(my $voteType = readdir(VOTES_FOLDER)){
	if($voteType ne "." && $voteType ne ".." && $voteType ne ".DS_Store"){
	    push(@voteTypes,$voteType);
	}
    }
    my @voteTypeNumbers;
    for my $voteType (@voteTypes){
	opendir(VOTE_TYPE_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/votes/$voteType") || die "Couldn't open the votes directory. $!";
	while(my $voteTypeNumber = readdir(VOTE_TYPE_FOLDER)){
	    if($voteTypeNumber ne "." && $voteTypeNumber ne ".." && $voteTypeNumber ne ".DS_Store"){
		push(@voteTypeNumbers,$CURRENT_DIRECTORY."/initialData/congress113_data/votes/$voteType/".$voteTypeNumber);
	    }
	}
    }

    for my $individualVote (@voteTypeNumbers){
	open(VOTE, $individualVote."/data.json") || die "Couldn't open the votes directory. $!";
	my @inputFile = <VOTE>;
	my $inputFile = join("",@inputFile);
	my $hashRef = decode_json($inputFile);
	my %vote = %$hashRef;
	my $insertString = &generateInsertStringFromHash($tableName,\@columns,\%vote);
	if($debug == 1){
	    print "Execute -->$insertString\n\n";
	}
	$sth = $dbh->prepare($insertString);
	$sth->execute or warn "Failed to insert Vote($sql) $DBI::errstr\n";
    }
}

sub loadCongressGithubAmendments{
    print "Installing Congress github amendments.\n";
    my $debug = 0;
    my $dbh = $_[0];
    if(!defined($dbh)){
	print "Undefined DBH !!!\n";
	exit();
    }
    my $tableName = "congress_github_amendments";
    my @columns = ("actions","status","introduced_at","description","sponsor","amends_bill","amends_amendment","amendment_id");

    my @columnTypes = ("VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)");

    my $columnsSize = @columns;
    my $typesSize = @columnTypes;
    
    if($columnsSize != $typesSize){
	warn("Size mismatch in loadVotes");
	exit();
    }

    # Drop table
    my $sql = "DROP TABLE IF EXISTS ".$tableName.";";
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "Drop Backend Tables: SQL Error: $DBI::errstr\n";
    
    # Create Table
    $sql = &generateCreateString($tableName,\@columns,\@columnTypes);
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    $sth = $dbh->prepare($sql);
    $sth->execute or die "Failed to create table; $DBI::errstr\n";

    # Populate Tables
    opendir(AMENDMENTS_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/amendments") || die "Couldn't open the amendments directory. $!";
    my @amendmentTypes;
    while(my $amendmentType = readdir(AMENDMENTS_FOLDER)){
	if($amendmentType ne "." && $amendmentType ne ".." && $amendmentType ne ".DS_Store"){
	    push(@amendmentTypes,$amendmentType);
	}
    }
    my @amendmentTypeNumbers;
    for my $amendmentType (@amendmentTypes){
	opendir(AMENDMENT_TYPE_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/amendments/$amendmentType") || die "Couldn't open the amendments directory. $!";
	while(my $amendmentTypeNumber = readdir(AMENDMENT_TYPE_FOLDER)){
	    if($amendmentTypeNumber ne "." && $amendmentTypeNumber ne ".." && $amendmentTypeNumber ne ".DS_Store"){
		push(@amendmentTypeNumbers,$CURRENT_DIRECTORY."/initialData/congress113_data/amendments/$amendmentType/".$amendmentTypeNumber);
	    }
	}
    }

    for my $individualAmendment (@amendmentTypeNumbers){
	open(AMENDMENT, $individualAmendment."/data.json") || die "Couldn't open the amendments directory. $!";
	my @inputFile = <AMENDMENT>;
	my $inputFile = join("",@inputFile);
	my $hashRef = decode_json($inputFile);
	my %amendment = %$hashRef;
	my $insertString = &generateInsertStringFromHash($tableName,\@columns,\%amendment);
	if($debug == 1){
	    print "Execute -->$insertString\n\n";
	}
	$sth = $dbh->prepare($insertString);
	$sth->execute or warn "Failed to insert Vote($sql) $DBI::errstr\n";
    }
}

sub loadAmendments{
    opendir(AMENDMENTS_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/amendments") || die "Couldn't open the amendments directory. $!";
    my @amendmentTypes;
    while(my $amendmentType = readdir(AMENDMENTS_FOLDER)){
	if($amendmentType  ne "." && $amendmentType ne ".." && $amendmentType ne ".DS_Store"){
	    push(@amendmentTypes,$amendmentType);
	}
    }
}
sub loadVotes{
    opendir(VOTES_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/votes/2014") || die "Couldn't open the votes directory. $!";
    my @voteTypes;
    while(my $voteType = readdir(VOTES_FOLDER)){
	if($voteType ne "." && $voteType ne ".." && $voteType ne ".DS_Store"){
	    push(@voteTypes,$voteType);
	}
    }
}

sub loadLegislatorsCsv{
    my $debug = 0;
    my $dbh = $_[0];
    my $tableName = "congress-legislators-github-csv";
    open(LEGISLATORS, $CURRENT_DIRECTORY."/initialData/congress-legislators/legislators.csv") || die "Couldn't open the legislators file. $!";
    
    my @columnTypes = ("VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)","VARCHAR(4000)");
    
    # Drop table
    my $sql = "DROP TABLE IF EXISTS ".$tableName.";";
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }    
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "Drop Backend Tables: SQL Error: $DBI::errstr\n";
    
    

    my $rowIndex = 0;
    my @columns;
    while(<LEGISLATORS>){
	if($rowIndex == 0){
	    # Read columns line and create table
	    my $columnString = $_;
	    chomp($columnString);
	    @columns = split(",",$columnString);
	    my $columnsSize = @columns;
	    my $typesSize = @columnTypes;
	    
	    # Create Table
	    $sql = &generateCreateString($tableName,\@columns,\@columnTypes);
	    if($debug == 1){
		print "Execute -->$sql\n\n";
	    }
	    $sth = $dbh->prepare($sql);
	    $sth->execute or die "Failed to create table; $DBI::errstr\n";
    
	    $rowIndex++;
	}
	else{
	    # Load into created table the data
	    my $insertRow = $_;
	    chomp($insertRow);
	    while($insertRow =~ /.*,,.*/){
		$insertRow =~ s/,,/,NULL,/g;
	    }
	    $insertRow =~ s/,$/,NULL/;
	    $insertRow =~ s/"(.*),(.*)"/"$1--COMMA--$2"/g;

	    my @columnData = split(",",$insertRow);
	    if(@columns != @columnData){
		print "Read bad line: ($_) <$insertRow>\n";
		exit();
	    }
	    for(my $index=0; $index < @columnData; $index++){
		$columnData[$index] =~ s/--COMMA--/,/g;
	    }
	    my $insertString = &generateInsertStringFromArray($tableName,\@columns, \@columnData);

	    if($debug == 1){
		print "Execute --> $insertRow";
	    }
	    $rowIndex++;
	}
    }
}

1;
