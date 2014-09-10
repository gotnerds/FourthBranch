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


# Stored Procedure TemplateS
my $SELECT_PROCEDURE_TEMPLATE = <<'END_SELECT_PROCEDURE_TEMPLATE';
DROP PROCEDURE IF EXISTS #PROCEDURE_NAME#;
DELIMITER // 
CREATE PROCEDURE #PROCEDURE_NAME# (#PARAMETER_LIST#) 
BEGIN 
SELECT #SELECT_COLUMNS# FROM #TABLE_NAME#
#WHERE_QUERY#;
END  
DELIMITER ; 
END_SELECT_PROCEDURE_TEMPLATE
    ;

my $DELETE_PROCEDURE_TEMPLATE = <<'END_DELETE_PROCEDURE_TEMPLATE';
DROP PROCEDURE IF EXISTS #PROCEDURE_NAME#;
DELIMITER // 
CREATE PROCEDURE #PROCEDURE_NAME# (#PARAMETER_LIST#) 
BEGIN 
DELETE FROM #TABLE_NAME#
#WHERE_QUERY#;
END  
DELIMITER ; 
END_DELETE_PROCEDURE_TEMPLATE
    ;

my $WRITE_PROCEDURE_TEMPLATE = <<'END_WRITE_PROCEDURE_TEMPLATE';
DROP PROCEDURE IF EXISTS #PROCEDURE_NAME#;
DELIMITER // 
CREATE PROCEDURE #PROCEDURE_NAME# (#PARAMETER_LIST#) 
BEGIN 
UPDATE #TABLE_NAME# SET #UPDATE_STRING# 
#WHERE_QUERY#;
END  
DELIMITER ; 
END_WRITE_PROCEDURE_TEMPLATE
    ;

my $INSERT_PROCEDURE_TEMPLATE = <<'END_INSERT_PROCEDURE_TEMPLATE';
DROP PROCEDURE IF EXISTS #PROCEDURE_NAME#;
DELIMITER // 
CREATE PROCEDURE #PROCEDURE_NAME# (#PARAMETER_LIST#) 
BEGIN 
INSERT INTO #TABLE_NAME# #COLUMNS# VALUES #INSERT_STRING#;
END 
DELIMITER ; 
END_INSERT_PROCEDURE_TEMPLATE
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

sub generateInsertProcedureFromHash{
    my $debug = 0;
    my $tableName = $_[0];
    my $procedureName = $_[1];
    my %insertHash = %{$_[2]};
    my $modifierString = $_[3];
    my @parameters = @{$_[4]};
    
    my $selectColumnsString = "";

    my $parameterList = "";
    my $addComma = 0;
    for my $param (@parameters){
	if( $addComma == 1){
	    $parameterList .= ",";
	}
	$addComma = 1;
	$parameterList .= " IN $param ";
    }
    
    my $columns = "";
    my $insertString = "";
    if(keys(%insertHash) >= 1){
	$columns = "(";
	$insertString = "(";
	my $addComma = 0;
	for my $key (keys(%insertHash)){
	    if($addComma == 1){
		$insertString .= " , ";
		$columns .= ",";
	    }
	    $addComma = 1;
	    $insertString .= "$insertHash{$key}";
	    $columns .= "$key";
	    
	}
	$insertString .= ")";
	$columns .= ")";
    }
    
    $insertString .= " $modifierString";

    my $procedure = $INSERT_PROCEDURE_TEMPLATE;
    $procedure =~ s/#PROCEDURE_NAME#/$procedureName/g;
    $procedure =~ s/#COLUMNS#/$columns/;
    $procedure =~ s/#INSERT_STRING#/$insertString/;
    $procedure =~ s/#TABLE_NAME#/$tableName/;
    $procedure =~ s/#PARAMETER_LIST#/$parameterList/;
    return $procedure;
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
    my $addComma = 0;
    for my $param (@parameters){
	if($addComma == 1){
	    $parameterList .= ",";
	}
	$addComma = 1;
	$parameterList .= " IN $param ";
    }
    $addComma = 0;
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
    my $procedure = $SELECT_PROCEDURE_TEMPLATE;
    $procedure =~ s/#PROCEDURE_NAME#/$procedureName/g;
    $procedure =~ s/#SELECT_COLUMNS#/$selectColumnsString/;
    $procedure =~ s/#TABLE_NAME#/$tableName/;
    $procedure =~ s/#WHERE_QUERY#/$whereQuery/;
    $procedure =~ s/#PARAMETER_LIST#/$parameterList/;
    return $procedure;
}

sub generateWriteProcedureFromHash{
    my $debug = 0;
    my $tableName = $_[0];
    my $procedureName = $_[1];
    my %updateHash = %{$_[2]};
    my %whereHash = %{$_[3]};
    my @parameters = @{$_[4]};
    
    my $selectColumnsString = "";

    my $parameterList = "";
    my $addComma = 0;
    for my $param (@parameters){
	if($addComma == 1){
	    $parameterList .= ",";
	}
	$addComma = 1;
	$parameterList .= " IN $param ";
    }

    my $updateString = "";
    if(keys(%updateHash) >= 1){
	my $addComma = 0;
	for my $key (keys(%updateHash)){
	    if($addComma == 1){
		$updateString .= " , ";
	    }
	    $addComma = 1;
	    $updateString .= "$updateHash{$key} = $key";
	    
	}
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
    my $procedure = $WRITE_PROCEDURE_TEMPLATE;
    $procedure =~ s/#PROCEDURE_NAME#/$procedureName/g;
    $procedure =~ s/#UPDAT_STRING#/$updateString/;
    $procedure =~ s/#UPDATE_STRING#/$updateString/;
    $procedure =~ s/#TABLE_NAME#/$tableName/;
    $procedure =~ s/#WHERE_QUERY#/$whereQuery/;
    $procedure =~ s/#PARAMETER_LIST#/$parameterList/;
    return $procedure;
}

sub generateDeleteProcedureFromHash{
    my $debug = 0;
    my $tableName = $_[0];
    my $procedureName = $_[1];
    my %whereHash = %{$_[2]};
    my @parameters = @{$_[3]};
    
    my $selectColumnsString = "";

    my $parameterList = "";
    my $addComma = 0;
    for my $param (@parameters){
	if($addComma == 1){
	    $parameterList .= ",";
	}
	$addComma = 1;
	$parameterList .= " IN $param ";
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
    my $procedure = $DELETE_PROCEDURE_TEMPLATE;
    $procedure =~ s/#PROCEDURE_NAME#/$procedureName/g;
    $procedure =~ s/#TABLE_NAME#/$tableName/;
    $procedure =~ s/#WHERE_QUERY#/$whereQuery/;
    $procedure =~ s/#PARAMETER_LIST#/$parameterList/;
    return $procedure;
}
