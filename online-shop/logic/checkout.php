<?php
function addOrder($first_name, $last_name, $email)
{
    $file = fopen('./data/orders.csv', 'a+');
    $data = $first_name . ',' . $last_name . ',' . $email . "\n";
    fwrite($file, $data);
    fclose($file);
}