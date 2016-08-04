<?php

global $g_bypass_headers;
$g_bypass_headers = 1;

require_once('core.php');

$data = file_get_contents("php://input");
file_put_contents('checkingit.log', $data);

$json = json_decode($data);

// Check if request contains any changes
if (!isset($json->push->changes)) {
    die("Invalid request.");
}

// Loop trough them changes
foreach ($json->push->changes as $change) {
    $diff_link = $change->links->diff->href;
    $branch = $change->new->name;

    foreach ($change->commits as $commit) {
        $userid = get_user_from_raw_name($commit->author->raw);
        if (!$userid) {
            $userid = get_user_from_raw_name($commit_account);
        }

        if (!auth_attempt_script_login($commit_account)) {
            die('Access denied!');
        }

        $msg = $commit->message;
        $matches = array();
        if (!preg_match_all($commit_regexp, $msg, $matches)) {
            continue;
        }

        $replaces = array(
            '{hash}' => $commit->hash,
            '{date}' => $commit->date,
            '{author}' => $commit->author->raw,
            '{branch}' => $branch,
            '{msg}' => $msg,
            '{files}' => git_get_files($diff_link),
        );

        $history_old = $history_new = '';
        $issues = array_unique($matches[1]);
        foreach ($issues as $issue_id) {
            $log = str_replace(array_keys($replaces), $replaces, $commit_template);
            helper_call_custom_function('checkin', array(
                $issue_id, $log, $history_old, $history_new, false));
        }
    }
}

function get_user_from_raw_name($name)
{
    while ($name) {
        $userid = user_get_id_by_name($name);
        if ($userid) {
            return $userid;
        }

        $name = substr($name, 0, strrpos($name, ' '));
    }

    return 0;
}

function git_get_files($link_to_diff)
{
    $ch = curl_init($link_to_diff);
    curl_setopt($ch, CURLOPT_USERPWD, 'username:password');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $files = array();
    foreach (preg_split('~[\r\n]+~', $response) as $line) {
        if (strpos($line, 'diff') === false) {
            continue;
        }

        $files[] = substr($line, strrpos($line, 'b/') + 2);
    }

    return implode(PHP_EOL, $files);
}
