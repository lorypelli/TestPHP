<?php
function generate_code(): string
{
    $code = mt_rand(100000, 999999);
    return strval($code);
}
