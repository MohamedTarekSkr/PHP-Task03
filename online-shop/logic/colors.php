<?php
require_once(BASE_PATH.'dal/dal.php');
function getColors()
{
    return get_rows("SELECT * FROM colors");
}