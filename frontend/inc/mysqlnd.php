<?php
class iimysqli_result
{
    public $statement, $nCols;
}    

function iimysqli_stmt_get_result($statement)
{
    /**    EXPLANATION:
     * We are creating a fake "result" structure to enable us to have
     * source-level equivalent syntax to a query executed via
     * mysqli_query().
     *
     *    $statement = mysqli_prepare($conn, "");
     *    mysqli_bind_param($statement, "types", ...);
     *
     *    $param1 = 0;
     *    $param2 = 'foo';
     *    $param3 = 'bar';
     *    mysqli_execute($statement);
     *    $result _mysqli_stmt_get_result($statement);
     *        [ $arr = _mysqli_result_fetch_array($result);
     *            || $assoc = _mysqli_result_fetch_assoc($result); ]
     *    mysqli_stmt_close($statement);
     *    mysqli_close($conn);
     *
     * At the source level, there is no difference between this and mysqlnd.
     **/
    $metadata = mysqli_stmt_result_metadata($statement);
    $ret = new iimysqli_result;
    if (!$ret) return NULL;

    $ret->nCols = mysqli_num_fields($metadata);
    $ret->stmt = $statement;

    mysqli_free_result($metadata);
    return $ret;
}

function iimysqli_result_fetch_array(&$results)
{
    $ret = array();
    $code = "return mysqli_stmt_bind_result(\$results->stmt ";

    for ($i=0; $i<$results->nCols; $i++)
    {
        $ret[$i] = NULL;
        $code .= ", \$ret['" .$i ."']";
    };

    $code .= ");";
    if (!eval($code)) { return NULL; };

    // This should advance the "$statement" cursor.
    if (!mysqli_stmt_fetch($results->stmt)) { return NULL; };

    // Return the array we built.
    return $ret;
}
?>