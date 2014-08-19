#!/usr/bin/perl
package CurrentLegislatorsCsv;
use strict;
use warnings;
use Cwd qw(cwd abs_path);
use vars qw($VERSION @ISA @EXPORT @EXPORT_OK %EXPORT_TAGS);


$VERSION     = 1.00;
@ISA         = qw(Exporter);
@EXPORT      = qw(loadLegislatorsCsv);
@EXPORT_OK   = qw(loadLegislatorsCsv);
%EXPORT_TAGS = ( DEFAULT => [qw(&loadLegislatorsCsv)]);

my $CURRENT_DIRECTORY = cwd();

my @types;
my $tableName = "legislators_csv_buffer";

sub loadLegislatorsCsv{
    my $debug = 0;
    print "Installing Legislators Csv\n";
    my $dbh = $_[0];
    if(!defined($dbh)){
	print "Undefined DBH !!!\n";
	exit();
    }
    open(INPUT,$CURRENT_DIRECTORY.'/initialData/legislators-current.csv') || die "Couldn't open input $!\n";

    my $index = 0;
    my $columnLine = <INPUT>;
    chomp($columnLine);
    my @columns = split(',',$columnLine);
    for my $column (@columns){
	push(@types,"TEXT");
    }
    my $sql = "DROP TABLE IF EXISTS ".$tableName.";";
    if($debug == 1){
	print "Execute -->$sql\n\n";
    }
    
    my $sth = $dbh->prepare($sql);
    $sth->execute or die "Drop Backend Tables: SQL Error: $DBI::errstr\n";
    
    $sql = &generateCreateString($tableName,\@columns,\@types);
    if($debug == 1){
	print "Execute -->$sql\n";
	<STDIN>;
    }
    $sth = $dbh->prepare($sql);
    $sth->execute or die "Drop Backend Tables: SQL Error: $DBI::errstr\n";

    while(<INPUT>){
	chomp();
	while(/.*,,.*/){
	    s/,,/,NULL,/g;
	}
	s/^,/NULL,/;
	s/,$/,NULL/;
	my @data = split(',',$_);
	$sql =  &generateInsertStringFromArray($tableName,\@columns,\@data);
	$index++;
	if($debug ==1 ){
	    print "Execute -->$sql\n";
	    <STDIN>;
	}
	$sth = $dbh->prepare($sql);
	$sth->execute or die "Drop Backend Tables: SQL Error: $DBI::errstr\n";
    }
    if($debug == 1){
	print "Length: $index\n";
    }
}

sub generateCreateString{
    my $tableName = $_[0];
    my @columns = @{$_[1]};
    my @types = @{$_[2]};
    my $columnsSize = @columns;
    my $typesSize = @types;
    if($columnsSize != $typesSize){
	print "size mismatch in generate create string " .($columnsSize - $typesSize) ."\n";
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

1;
