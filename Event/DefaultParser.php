<?php

namespace Event;

use Tools\TemplateHandler;

class DefaultParser
{

    const COMMIT_REGEXP = '~(?:#|issue )(\d+)~i';

    private $custom_template;
    private $fallback_account;

    public function setCustomTemplate($custom_template)
    {
        $this->custom_template = $custom_template;
        return $this;
    }

    public function getCustomTemplate()
    {
        return $this->custom_template;
    }

    public function setFallbackAccount($fallback_account)
    {
        $this->fallback_account = $fallback_account;
        return $this;
    }

    public function getFallbackAccount()
    {
        return $this->fallback_account;
    }

    /**
     * Get closest "username" from any given name string
     * @param string $name
     * @return string
     */
    public function getUserFromRawName($name)
    {
        $email = substr($name, strpos($name, '<') + 1, -1);
        $userid = user_get_id_by_email($email);
        if ($userid) {
            $user = user_get_row($userid);
            return $user['username'];
        }

        $parts = preg_split('~[^\w]+~', $name);
        foreach ($parts as $part) {
            $userid = user_get_id_by_name($part);
            if ($userid) {
                $user = user_get_row($userid);
                return $user['username'];
            }
        }

        return '';
    }

    public function gitGetFiles($link_to_diff)
    {
        $git_username = config_get('git_username');
        $git_password = config_get('git_password');

        $ch = curl_init($link_to_diff);
        curl_setopt($ch, CURLOPT_USERPWD, $git_username . ':' . $git_password);
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

    protected function processTemplate(array $data)
    {
        $template_handler = new TemplateHandler;

        $template_handler->setTemplate($this->custom_template);

        $template_handler->setData($data);

        return $template_handler->processTemplate();
    }

    protected function getIssue($commit_message)
    {
        $result = preg_match(self::COMMIT_REGEXP, $commit_message);

        if (!$result) {
            return null;
        }

        return $result;
    }

    protected function createComment($issue, $content)
    {
        helper_call_custom_function('checkin', array(
            $issue, $content, '', '', false));
    }
}
