<?php

function getconn()
{
    $con = mysql_connect("localhost:3336","root","myoa888");
    $db = mysql_select_db("TD_OA"); //ักิ๑สýพÝฟโ 
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    else
    {
        return $con;
    }
}

function exequery($conn="",$sql="")
{
    
    $cursor = mysql_query($sql,$conn);
    
    if(!$cursor)
    {
        print_r("sql error:".$sql);
    }
    
    return $cursor;
    
}


?>