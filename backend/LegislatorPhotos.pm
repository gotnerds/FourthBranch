#!/usr/bin/perl
package LegislatorPhotos;

use warnings;
use CGI::Carp 'fatalsToBrowser';
use CGI qw/:standard/;
use Cwd qw(cwd abs_path);
use File::Basename 'dirname';
use lib dirname(abs_path $0);
use strict;
use Exporter;
use vars qw($VERSION @ISA @EXPORT @EXPORT_OK %EXPORT_TAGS);
use MysqlUtils qw(:DEFAULT);

$VERSION     = 1.00;
@ISA         = qw(Exporter);
@EXPORT      = ();
@EXPORT_OK   = qw();
%EXPORT_TAGS = ( DEFAULT => [qw()]);

my $CURRENT_DIRECTORY = cwd();


sub loadImages{
    my $debug = 0;
    my $dbh = $_[0];
    my $tableName = "congress_github_images";
    my @columns = ("bioguide_id","original","225x275","450x550");

    my @columnTypes = ("VARCHAR(20) UNIQUE","TEXT","TEXT","TEXT");

    my $columnsSize = @columns;
    my $typesSize = @columnTypes;

    print "Installing Legislator Photos\n";

    if($columnsSize != $typesSize){
	die("Size mismatch in loadBills");
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

    my $orignalImageFolder = $CURRENT_DIRECTORY."/initialData/images/original";
# Populate Tables
    opendir(IMAGES_ORIGINAL_FOLDER, $orignalImageFolder) || die "Couldn't open $orignalImageFolder directory. $!";
    my @imagesOriginal;
    while(my $image = readdir(IMAGES_ORIGINAL_FOLDER)){
	if($image ne "." && $image ne ".." && $image ne ".DS_Store"){
	    push(@imagesOriginal,$image);
	}
    }
    my $mediumImageFolder =  $CURRENT_DIRECTORY."/initialData/images/450x550";
    opendir(IMAGES_MEDIUM_FOLDER,$mediumImageFolder) || die "Couldn't open $mediumImageFolder directory. $!";
    my @imagesMedium;
    while(my $image = readdir(IMAGES_MEDIUM_FOLDER)){
	if($image ne "." && $image ne ".." && $image ne ".DS_Store"){
	    push(@imagesMedium,$image);
	}
    }
    
    my $smallImageFolder = $CURRENT_DIRECTORY."/initialData/images/225x275";
    opendir(IMAGES_SMALL_FOLDER,$smallImageFolder ) || die "Couldn't open $smallImageFolder directory. $!";
    my @imagesSmall;
    while(my $image = readdir(IMAGES_SMALL_FOLDER)){
	if($image ne "." && $image ne ".." && $image ne ".DS_Store"){
	    push(@imagesSmall,$image);
	}
    }
    my $sqlTemplate = 'INSERT INTO #tableName# (bioguide_id,#size#) VALUES(\'#bioguide#\',\'#file#\') ON DUPLICATE KEY UPDATE #size#=\'#file#\'';
    $sqlTemplate =~ s/#tableName#/$tableName/g;
    
    # Insert original
    for my $image (@imagesOriginal){
	my $bioguideId = $image;
	$bioguideId =~ s/\.jpg//g;
	my $sql = $sqlTemplate;
	while($sql =~ /#size#/){
	    $sql =~ s/#size#/original/g;
	}
	while($sql =~ /#bioguide#/){
	    $sql =~ s/#bioguide#/$bioguideId/g;
	}
	while($sql =~ /#file#/){
	    $sql =~ s@#file#@${orignalImageFolder}/${image}@g;
	}
	if ($debug == 1){
	    print "--> Execute $sql\n";
	}
	$sth = $dbh->prepare($sql);
	$sth->execute or die "SQL Error: $DBI::errstr\n";
    }

    # Insert 225x275
    for my $image (@imagesSmall){
	my $bioguideId = $image;
	$bioguideId =~ s/\.jpg//g;
	my $sql = $sqlTemplate;
	while($sql =~ /#size#/){
	    $sql =~ s/#size#/225x275/g;
	}
	while($sql =~ /#bioguide#/){
	    $sql =~ s/#bioguide#/$bioguideId/g;
	}
	while($sql =~ /#file#/){
	    $sql =~ s@#file#@${smallImageFolder}/${image}@g;
	}
	if ($debug == 1){
	    print "--> Execute $sql\n";
	}
	$sth = $dbh->prepare($sql);
	$sth->execute or die "SQL Error: $DBI::errstr\n";
    }

    # Insert 450x550
    for my $image (@imagesMedium){
	my $bioguideId = $image;
	$bioguideId =~ s/\.jpg//g;
	my $sql = $sqlTemplate;
	while($sql =~ /#size#/){
	    $sql =~ s/#size#/450x550/g;
	}
	while($sql =~ /#bioguide#/){
	    $sql =~ s/#bioguide#/$bioguideId/g;
	}
	while($sql =~ /#file#/){
	    $sql =~ s@#file#@${mediumImageFolder}/${image}@g;
	}
	if ($debug == 1){
	    print "--> Execute $sql\n";
	}
	$sth = $dbh->prepare($sql);
	$sth->execute or die "SQL Error: $DBI::errstr\n";
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
