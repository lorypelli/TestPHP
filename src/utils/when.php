<?php
function when(mixed $condition, string $str): string
{
    return boolval($condition) ? $str : '';
}
