<?php
use LDAP\Result;

define('db_server', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'shop');
function get_rows($q)
{
    $rows = [];
    $con = new mysqli(db_server, db_username, db_password, db_dbname);
    if ($con->connect_error) {
        return [];
    }
    $q = $con->query($q);
    while ($row = $q->fetch_assoc()) {
        array_push($rows, $row);
    }
    $con->close();
    return $rows;
}

function get_row($q)
{
    $row = null;
    $con = new mysqli(db_server, db_username, db_password, db_dbname);
    if ($con->connect_error) {
        return null;
    }
    $q = $con->query($q);
    $row = $q->fetch_assoc();
    $con->close();
    return $row;
}
function execute($q)
{
    $result = false;
    $con = new mysqli(db_server, db_username, db_password, db_dbname);
    if ($con->connect_error) {
        return $result;
    }
    $result = $con->query($q);
    $con->close();
    return $result;
}

function get_user($username, $password)
{
    $row = null;
    $con = new mysqli(db_server, db_username, db_password, db_dbname);
    if ($con->connect_error) {
        return null;
    }
    $stmt = $con->prepare("SELECT * FROM users WHERE username=? and password=?");
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $con->close();
    
    return $row;
}