<?php
$root = $_SERVER['DOCUMENT_ROOT'];
function show_fallback_avatar(): void
{
    global $root;
    readfile(sprintf('%s/avatar/fallback.png', $root));
    exit(0);
}
