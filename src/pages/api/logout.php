<?php
$sessions->delete($token);
$cookies->remove('user_token');
session_destroy();
redirect('/');
