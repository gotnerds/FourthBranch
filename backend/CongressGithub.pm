#!/usr/bin/perl
package CongressGithub;
use strict;
use warnings; 
use Cwd qw(cwd abs_path);
use JSON::PP qw(decode_json encode_json);
use DBI;
use CGI::Carp 'fatalsToBrowser';
use vars qw($VERSION @ISA @EXPORT @EXPORT_OK %EXPORT_TAGS);
use MysqlUtils qw(:DEFAULT);


$VERSION     = 1.00;
@ISA         = qw(Exporter);
@EXPORT      = qw();
@EXPORT_OK   = qw();
%EXPORT_TAGS = ( DEFAULT => [qw()]);

my $CURRENT_DIRECTORY = cwd();


sub loadCongressGithubBills{
    print "Installing Congress github bills. This can take like 10 minutes\n";
    my $debug = 0;
    my $dbh = $_[0];
    if(!defined($dbh)){
	print "Undefined DBH !!!\n";
	exit();
    }
    my $tableName = "congress_github_bills";
    my @columns = ("official_title","bill_type","status","updated_at","status_at","bill_id","subjects_top_term","enacted_as","number","short_title","introduced_at","congress","by_request","popular_title","bill_html","history","related_bills");

    my @columnTypes = ("TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT");

    my $columnsSize = @columns;
    my $typesSize = @columnTypes;
    
    if($columnsSize != $typesSize){
	die("Size mismatch in loadBills");
    }

    # Drop table
    my $sql = "DROP TABLE IF EXISTS ".$tableName.";";
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "SQL Error: $DBI::errstr\n";
    
    # Create Table
    $sql = MysqlUtils::generateCreateString($tableName,\@columns,\@columnTypes);
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    $sth = $dbh->prepare($sql);
    $sth->execute or die "Failed to create table; $DBI::errstr\n";

    # Populate Tables
    opendir(BILLS_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/bills") || die "Couldn't open ${CURRENT_DIRECTORY}/initialData/congress113_data/billsdirectory. $!";
    my @billTypes;
    while(my $billType = readdir(BILLS_FOLDER)){
	if($billType ne "." && $billType ne ".." && $billType ne ".DS_Store"){
	    push(@billTypes,$billType);
	}
    }
    my @billTypeNumbers;
    for my $billType (@billTypes){
	opendir(BILL_TYPE_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/bills/$billType") || die "Couldn't open ${CURRENT_DIRECTORY}/initialData/congress113_data/bills/$billType directory. $!";
	while(my $billTypeNumber = readdir(BILL_TYPE_FOLDER)){
	    if($billTypeNumber ne "." && $billTypeNumber ne ".." && $billTypeNumber ne ".DS_Store"){
		push(@billTypeNumbers,$CURRENT_DIRECTORY."/initialData/congress113_data/bills/$billType/".$billTypeNumber);
	    }
	}
    }

    for my $individualBill (@billTypeNumbers){
	open(BILL, $individualBill."/data.json") || die "Couldn't open  ${individualBill}/data.json the bills directory. $!";
	my @inputFile = <BILL>;
	my $inputFile = join("",@inputFile);
	my $hashRef = decode_json($inputFile);
	my %bill = %$hashRef;
	# Verify location of bill html
	if(-e $individualBill."/data.html"){
	    $bill{'bill_html'} = $individualBill."/data.html";
	}
	if( defined $bill{'enacted_as'}){
	    $bill{'enacted_as'} = encode_json($bill{'enacted_as'});
	}
	if( exists $bill{'history'}){
	    $bill{'history'} = encode_json($bill{'history'});
	}
	if( exists $bill{'related_bills'}){
	    $bill{'related_bills'} = encode_json($bill{'related_bills'});
	}
	my $insertString = MysqlUtils::generateInsertStringFromHash($tableName,\@columns,\%bill);
	if($debug == 1){
	    print "Execute -->$insertString\n\n";
	}
	$sth = $dbh->prepare($insertString);
	$sth->execute or warn "Failed to insert Bill($sql) $DBI::errstr\n";
    }
}

sub unusedloadRepresentativePhotos{
    my $debug = 0;
    my $dbh = $_[0];
    my $outputFile = $_[1];

    my $insertTemplate = "INSERT INTO congress_github_images (bioguide_id,#column#) VALUES('#bioguide#','#column_data#') ON DUPLICATE KEY UPDATE #column#='#column_data#';";
    #open(OUTPUT,">>$outputFile") || die "Couldn't open $outputFile. SQL Error $DBI::errstr\n";
    my $currentDirectory = cwd();
    my @directories;
    my $found225 = 0;
    my $found450 = 0;
    if(-e $currentDirectory."/initialData/images/225x275"){
	$found225 = 1;
    }
    if(-e $currentDirectory."/initialData/images/450x550"){
	$found450 = 1;
    }
    if(! -e $currentDirectory."/initialData/images/original"){
	print "Couldn't find original image directory\n";
	exit();
    }
    print "Parsing original directory\n";
    opendir(INPUT,$currentDirectory."/initialData/images/original" ) || die "Couldn't open original directory. $!";
   
    while(my $photo = readdir(INPUT)){ 
	
	if($photo eq "." || $photo eq ".."){
	    next;
	}
	my $sql = $insertTemplate;
	$sql =~ s/#column#/original/g;
	$photo =~ m@(.*)\..*$@;
	my $id = $1;
	$sql =~ s/#bioguide#/$id/g;
	my $fileName = $currentDirectory."/initialData/images/original/".$photo;
	$sql =~ s/#column_data#/$fileName/g;
	if($debug == 1){
	    print "Writing -->$sql\n";
	}
	my $sth = $dbh->prepare($sql);
	$sth->execute or die "SQL Error: $DBI::errstr\n";
    }

    if($found225 == 1){
	print "Parsing 225 directory\n";
	opendir(INPUT,$currentDirectory."/initialData/images/225x275" ) || die "Couldn't open 225 directory. $!";
	
	while(my $photo = readdir(INPUT)){
	    if($photo eq "." || $photo eq ".."){
		next;
	    }
	    my $sql = $insertTemplate;
	    $sql =~ s/#column#/225x275/g;
	    $photo =~ m@(.*)\..*$@;
	    my $id = $1;
	    $sql =~ s/#bioguide#/$id/g;
	    my $fileName = $currentDirectory."/initialData/images/225x275/".$photo;
	    $sql =~ s/#column_data#/$fileName/g;
	    if($debug == 1){
		print "Writing -->$sql\n";
	    }
	    my $sth = $dbh->prepare($sql);
	    $sth->execute or die "SQL Error: $DBI::errstr\n";
	}
    }

    if($found450 == 1){
	print "Parsing 450 directory\n";
	opendir(INPUT,$currentDirectory."/initialData/images/450x550" ) || die "Couldn't open 450 directory. $!";
	
	while(my $photo = readdir(INPUT)){
	    if($photo eq "." || $photo eq ".."){
		next;
	    }
	    my $sql = $insertTemplate;
	    $sql =~ s/#column#/450x550/g;
	    $photo =~ m@(.*)\..*$@;
	    my $id = $1;
	    $sql =~ s/#bioguide#/$id/g;
	    my $fileName = $currentDirectory."/initialData/images/450x550/".$photo;
	    $sql =~ s/#column_data#/$fileName/g;
	    if($debug == 1){
		print "Writing -->$sql\n";
	    }
	    my $sth = $dbh->prepare($sql);
	    $sth->execute or die "SQL Error: $DBI::errstr\n";
	}

    }
}

sub loadCongressGithubVotes{
    print "Installing Congress github votes. This can take 4 minutes.\n";
    my $debug = 0;
    my $dbh = $_[0];
    if(!defined($dbh)){
	print "Undefined DBH !!!\n";
	exit();
    }
    my $tableName = "congress_github_votes";
    my @columns = ("vote_id","bill","date","question","result","votes");

    my @columnTypes = ("TEXT","TEXT","TEXT","TEXT","TEXT","LONGTEXT");

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
    $sql = MysqlUtils::generateCreateString($tableName,\@columns,\@columnTypes);
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    $sth = $dbh->prepare($sql);
    $sth->execute or die "Failed to create table; $DBI::errstr\n";

    # Populate Tables
    opendir(VOTES_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/votes") || die "Couldn't open ${CURRENT_DIRECTORY}/initialData/congress113_data/votes directory. $!";
    my @voteTypes;
    while(my $voteType = readdir(VOTES_FOLDER)){
	if($voteType ne "." && $voteType ne ".." && $voteType ne ".DS_Store"){
	    push(@voteTypes,$voteType);
	}
    }
    my @individualVotes;
    for my $voteType (@voteTypes){
	opendir(VOTE_TYPE_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/votes/$voteType") || die "Couldn't open ${CURRENT_DIRECTORY}/initialData/congress113_data/votes/$voteType directory. $!";
	while(my $individualVote = readdir(VOTE_TYPE_FOLDER)){
	    if($individualVote ne "." && $individualVote ne ".." && $individualVote ne ".DS_Store"){
		if($individualVote =~ /\.json$/){
		    #print "adding vote $CURRENT_DIRECTORY/initialData/congress113_data/votes/$voteType/$individualVote\n";
		    push(@individualVotes,$CURRENT_DIRECTORY."/initialData/congress113_data/votes/$voteType/".$individualVote);
		}
	    }
	}
    }
    
    for my $individualVote (@individualVotes){
	open(VOTE, $individualVote) || die "Couldn't open $individualVote directory (${individualVote}). $!";
	my @inputFile = <VOTE>;
	my $inputFile = join("",@inputFile);
	my $hashRef = decode_json($inputFile);
	my %vote = %$hashRef;
	my %bill;
	if(exists $vote{'bill'}){
	    my $billRef = $vote{'bill'};
	    %bill = %$billRef;
	    $vote{"bill"} = encode_json(\%bill);
	}
	if(exists $vote{'votes'}){
	    my $voteRef = $vote{'votes'};
	    my %votesInfo = %$voteRef;
	    $vote{'votes'} = encode_json(\%votesInfo);
	}
	my $insertString = MysqlUtils::generateInsertStringFromHash($tableName,\@columns,\%vote);
	if($debug == 1){
	    print "Execute -->$insertString\n\n";
	    <STDIN>;
	}
	$sth = $dbh->prepare($insertString);
	$sth->execute or warn "Failed to insert Vote($sql) $DBI::errstr\n";
    }
}

sub loadCongressGithubAmendments{
    print "Installing Congress github amendments. This can take 4 minutes\n";
    my $debug = 0;
    my $dbh = $_[0];
    if(!defined($dbh)){
	print "Undefined DBH !!!\n";
	exit();
    }
    my $tableName = "congress_github_amendments";
    my @columns = ("actions","status","introduced_at","description","sponsor","amends_bill","amends_amendment","amendment_id");

    my @columnTypes = ("TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT");

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
    $sql = MysqlUtils::generateCreateString($tableName,\@columns,\@columnTypes);
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    $sth = $dbh->prepare($sql);
    $sth->execute or die "Failed to create table; $DBI::errstr\n";

    # Populate Tables
    opendir(AMENDMENTS_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/amendments") || die "Couldn't open ${CURRENT_DIRECTORY}/initialData/congress113_data/amendments directory. $!";
    my @amendmentTypes;
    while(my $amendmentType = readdir(AMENDMENTS_FOLDER)){
	if($amendmentType ne "." && $amendmentType ne ".." && $amendmentType ne ".DS_Store"){
	    push(@amendmentTypes,$amendmentType);
	}
    }
    my @amendmentTypeNumbers;
    for my $amendmentType (@amendmentTypes){
	opendir(AMENDMENT_TYPE_FOLDER, $CURRENT_DIRECTORY."/initialData/congress113_data/amendments/$amendmentType") || die "Couldn't open ${CURRENT_DIRECTORY}/initialData/congress113_data/amendments/$amendmentType directory. $!";
	while(my $amendmentTypeNumber = readdir(AMENDMENT_TYPE_FOLDER)){
	    if($amendmentTypeNumber ne "." && $amendmentTypeNumber ne ".." && $amendmentTypeNumber ne ".DS_Store"){
		push(@amendmentTypeNumbers,$CURRENT_DIRECTORY."/initialData/congress113_data/amendments/$amendmentType/".$amendmentTypeNumber);
	    }
	}
    }

    for my $individualAmendment (@amendmentTypeNumbers){
	open(AMENDMENT, $individualAmendment."/data.json") || die "Couldn't open $individualAmendment/data.json directory. $!";
	my @inputFile = <AMENDMENT>;
	my $inputFile = join("",@inputFile);
	my $hashRef = decode_json($inputFile);
	my %amendment = %$hashRef;
	if (exists ($amendment{'actions'})){
	    $amendment{'actions'} = encode_json($amendment{'actions'});
	}
	if (exists ($amendment{'amends_bill'})){
	    $amendment{'amends_bill'} = encode_json($amendment{'amends_bill'});
	}
	if (exists ($amendment{'sponsor'})){
	    $amendment{'sponsor'} = encode_json($amendment{'sponsor'});
	}
	if(defined($amendment{'amends_amendment'})){
	    $amendment{'amends_amendment'} = encode_json($amendment{'amends_amendment'});
	    while($amendment{'amends_amendment'} =~ /.*\\"/){
		$amendment{'amends_amendment'} =~ s/\\"(.*)\\"/<$1>/g;
		if($debug == 1){
		    print $amendment{'amends_amendment'};
		    <STDIN>;
		}
	    }
	}



	while($amendment{'sponsor'} =~ /.*\\"/){
	    $amendment{'sponsor'} =~ s/\\"(.*)\\"/<$1>/g;
	   if($debug == 1){
	       print $amendment{'sponsor'};
	       <STDIN>;
	   }
	}
	while($amendment{'amends_bill'} =~ /.*\\"/){
	    $amendment{'amends_bill'} =~ s/\\"(.*)\\"/<$1>/g;
	    
	    if($debug == 1){
		print $amendment{'amends_bill'};
		<STDIN>;
	    }
	}
	while($amendment{'actions'} =~ /.*\\"/){
	    $amendment{'actions'} =~ s/\\"(.*?)\\"/<$1>/g;
	    if($debug == 1){
		print $amendment{'actions'};
		<STDIN>;
	    }
	}

	$sql = MysqlUtils::generateInsertStringFromHash($tableName,\@columns,\%amendment);
	# Remove occurrences of \\"
	
	if($debug == 1){
	    print "Execute -->$sql\n\n";
	    <STDIN>;
	}
	$sth = $dbh->prepare($sql);
	$sth->execute or die "Failed to insert Amendment($sql) $DBI::errstr\n";
    }
}

sub loadLegislatorsCsv{
    my $debug = 0;
    my $dbh = $_[0];
    my $tableName = "congress-legislators-github-csv";
    open(LEGISLATORS, $CURRENT_DIRECTORY."/initialData/congress-legislators/legislators.csv") || die "Couldn't open ${CURRENT_DIRECTORY}/initialData/congress-legislators/legislators.csv file. $!";
    
    my @columnTypes = ("TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT","TEXT");
    
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
	    $sql = MysqlUtils::generateCreateString($tableName,\@columns,\@columnTypes);
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
	    my $insertString = MysqlUtils::generateInsertStringFromArray($tableName,\@columns, \@columnData);

	    if($debug == 1){
		print "Execute --> $insertRow";
	    }
	    $rowIndex++;
	}
    }
}

1;
