<?php
function uploadFile($file)
{
    $time = (int) floor(microtime(true) * 1000);
    $fileName = $time . $file['name'];
    $ext_arr = explode('.', $file['name']);
    $fileName = $time . (count($ext_arr) > 0 ? '.' . $ext_arr[count($ext_arr) - 1] : '');
    move_uploaded_file($file['tmp_name'], BASE_PATH . 'uploads/' . $fileName);
    return 'uploads/' . $fileName;
}