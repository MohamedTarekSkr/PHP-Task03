<?php
function validate($arr, $val)
{
    if (!isset($arr[$val])) {
        return false;
    }
    return htmlspecialchars(trim(stripslashes($arr[$val])));
}

function validateEmail($arr, $val)
{
    $email = validate($arr, $val);
    if (!$email)
        return false;
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateFile($arr, $val, $maxSize, $type)
{
    if (!isset($arr[$val])) {
        return false;
    }
    if ($arr[$val]['size'] > $maxSize || $arr[$val]['error'] != 0)
        return false;
    if (!in_array($arr[$val]['type'],$type))
        return false;
    return $arr[$val];
}