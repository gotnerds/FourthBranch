#!/usr/bin/perl
package MysqlUtils;
use strict;
use warnings; 
use Cwd qw(cwd abs_path);
use JSON::PP qw(decode_json encode_json);
use DBI;
use CGI::Carp 'fatalsToBrowser';
use vars qw($VERSION @ISA @EXPORT @EXPORT_OK %EXPORT_TAGS);


$VERSION     = 1.00;
@ISA         = qw(Exporter);
@EXPORT      = qw();
@EXPORT_OK   = qw(generateCreateString generateInsertStringFromHash generateInsertStringFromArray);
%EXPORT_TAGS = ( DEFAULT => [qw(&generateCreateString &generateInsertStringFromHash &generateInsertStringFromArray)]);

my $CURRENT_DIRECTORY = cwd();


# Stored Procedure Template
my $STORED_PROCEDURE_TEMPLATE = <<'END_STORED_PROCEDURE_TEMPLATE';
DELIMITER // 
CREATE PROCEDURE #PROCEDURE_NAME# (#PARAMETER_LIST#) 
BEGIN 
SELECT #SELECT_COLUMNS# FROM #TABLE_NAME#
#WHERE_QUERY#;
END // 
DELIMITER ; 
END_STORED_PROCEDURE_TEMPLATE
    ;

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
	    my $sanitized = $hash{$key};
	    $sanitized =~ s/"/\\"/g;
	    $insertString .= " \"${sanitized}\" ";
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
    my $arraySize = @array;

    if($arraySize != $columnSize){
	print "Size Mismatch in generate insert String from array. ArraySize: $arraySize  ColumnSize: $columnSize\n";
    }
    my $insertString = " INSERT INTO $tableName (";
    for(my $index = 0; $index < $columnSize; $index++){
       	$insertString .= $columns[$index];
	if($index+1 != $columnSize){
	    $insertString .= ",";
	}
    }
    $insertString .= ") VALUES (";
    
    for(my $index=0; $index < $columnSize; $index++){
	
	my $sanitized = $array[$index];
	if(!defined($sanitized)){
	    $sanitized = "NULL";
	}
	$sanitized =~ s/"/\\"/g;
	$insertString .= " \"${sanitized}\" ";
	if($index+1 != $columnSize){
	    $insertString .= ",";
	}
    }
    $insertString .= ");";
    if($debug == 1){
	print "Generated insert string: $insertString\n";           ;
    }
    return $insertString;
}

sub generateReadProcedureFromHash{
    my $debug = 0;
    my $tableName = $_[0];
    my $procedureName = $_[1];
    my @selectColumns = @{$_[2]};
    my %whereHash = %{$_[3]};
    my @parameters = @{$_[4]};
    
    
    my $selectColumnsString = "";

    my $parameterList = "";
    for my $param (@parameters){
	$parameterList .= "IN $param";
    }
    my $addComma = 0;
    for my $column (@selectColumns){
	if($addComma == 1){
	    $selectColumnsString .= ",";
	}
	$addComma = 1;
	$selectColumnsString .= $column;
    }

    my $whereQuery = "";
    if(keys(%whereHash) >= 1){
	$whereQuery = "WHERE ";
	my $addAnd = 0;
	for my $key (keys(%whereHash)){
	    if($addAnd == 1){
		$whereQuery .= " AND ";
	    }
	    $addAnd = 1;
	    $whereQuery .= "$key = $whereHash{$key}";
	    
	}
    }
    my $procedure = $STORED_PROCEDURE_TEMPLATE;
    $procedure =~ s/#PROCEDURE_NAME#/$procedureName/;
    $procedure =~ s/#SELECT_COLUMNS#/$selectColumnsString/;
    $procedure =~ s/#TABLE_NAME#/$tableName/;
    $procedure =~ s/#WHERE_QUERY#/$whereQuery/;
    $procedure =~ s/#PARAMETER_LIST#/$parameterList/;
    return $procedure;
}
