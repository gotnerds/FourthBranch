#!/usr/bin/perl 
use strict;
use warnings; 
use Cwd qw(cwd abs_path);
use JSON::PP qw(decode_json encode_json);
use DBI;
use CGI::Carp 'fatalsToBrowser';


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

sub generateInsertString{
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

sub loadBills{
    my $debug = 0;
    my $dbh = $_[0];
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
	my $insertString = &generateInsertString($tableName,\@columns,\%bill);
	if($debug == 1){
	    print "Execute -->$insertString\n\n";
	}
	$sth = $dbh->prepare($insertString);
	$sth->execute or warn "Failed to insert Bill($sql) $DBI::errstr\n";
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

1;
