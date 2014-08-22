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
    my $sqlTemplate = 'INSERT INTO #tableName# (bioguide_id,#size#) VALUES(#bioguide#,#file#) ON DUPLICATE KEY UPDATE #size#=VALUES(#file#)';
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
    }
}
