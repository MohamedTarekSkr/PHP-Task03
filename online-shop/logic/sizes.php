<?php
require_once(BASE_PATH.'dal/dal.php');
function getSizes()
{
    return get_rows("SELECT * FROM sizes");
}