<?php

namespace Event\Repository;

use Event\DefaultParser;

class Push extends DefaultParser
{

    public function parse($json)
    {
        // Loop trough the changes
        foreach ($json->push->changes as $change) {
            $diff_link = $change->links->diff->href;
            $branch = $change->new->name;

            foreach ($change->commits as $commit) {
                $this->processCommit($commit, $branch, $diff_link);
            }
        }
    }

    private function processCommit($commit, $branch, $diff_link)
    {
        $username = $this->getUserFromRawName($commit->author->raw);
        if (!$username) {
            $username = $this->getFallbackAccount();
        }

        if (!auth_attempt_script_login($username)) {
            die('Access denied!');
        }

        $msg = $commit->message;
        $matches = array();
        if (!preg_match_all($this->getCommitRegexp(), $msg, $matches)) {
            return false;
        }

        $replaces = array(
            '{hash}' => $commit->hash,
            '{date}' => $commit->date,
            '{author}' => $commit->author->raw,
            '{branch}' => $branch,
            '{msg}' => $msg,
            '{files}' => $this->gitGetFiles($diff_link),
        );

        $history_old = $history_new = '';
        $issues = array_unique($matches[1]);
        $this->checkin($issues, $history_old, $history_new, $replaces);
    }

    private function checkin(array $issues, $history_old, $history_new, $replaces)
    {
        foreach ($issues as $issue_id) {
            $log = str_replace(array_keys($replaces), $replaces, $this->getCustomTemplate());
            helper_call_custom_function('checkin', array(
                $issue_id, $log, $history_old, $history_new, false));
        }
    }
}
