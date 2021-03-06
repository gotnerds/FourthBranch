#!C:/ampps/perl/bin/perl.exe
use Cwd qw(cwd abs_path);
use strict;
use warnings;

my $CURRENT_DIRECTORY = cwd();
opendir(INPUT, $CURRENT_DIRECTORY) || die "Couldn't open ${CURRENT_DIRECTORY}. !";
while(my $file = readdir(INPUT)){
    if($file =~ /\.pm$/ || $file =~ /\.pl$/){
	print "Editing $file";
	open(INFILE,$file) || die "couldn't open output file $!";
	open(OUTPUT,'>__tmp_out__') || die "couldn't open output $!";
	my $shabang = <INFILE>;
	chomp($shabang);
	if($shabang =~ m@^#!/usr/bin/perl@){
	    print ' Outputting windows ';
	   	print OUTPUT '#!C:/ampps/perl/bin/perl.exe'."\n";
	}
	else {
	    print " Outputing linux -->$shabang<--";
	    print OUTPUT '#!/usr/bin/perl'."\n";
        ##<STDIN>
	}
	while(my $inLine = <INFILE>){
	    print OUTPUT $inLine;
	}
	close(OUTPUT);
	close(INFILE);
	rename('__tmp_out__',$file);
	print "\n";
    }
}
