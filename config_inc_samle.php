<?php

// Bitbucket integration example settings
$g_git_fallback_account = 'git';
$g_git_template = '<b>---------- Source Code Changes ----------</b>' . PHP_EOL
    . '<b>GIT Revision:</b> {{hash}} by {{author}}, {{date}}' . PHP_EOL
    . '<b>GIT Branch:</b> {{branch}}' . PHP_EOL
    . '<b>GIT Log:</b>' . PHP_EOL . '{{msg}}' . PHP_EOL
    . '<b>GIT Files:</b>' . PHP_EOL
    . '{{files}}';
$g_git_username = 'username';
$g_git_password = 'password';