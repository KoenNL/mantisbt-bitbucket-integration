<?php

namespace Tools;

class Loader
{

    const DEFAUL_PARSER_FILE = 'parsers/default_parser.php';
    
    private $document_root;
    private $event_keys = array(
        'repo' => array(
            'folder' => 'repo',
            'events' => array(
                'push' => 'Push',
                'fork' => 'Fork',
                'updated' => 'Updated',
                'commit_comment_created' => 'CommitCommentCreated',
                'commit_status_created' => 'CommitStatusCreated',
                'commit_status_updated' => 'CommitStatusUpdated',
            ),
        ),
        'issue' => array(
            'folder' => 'issue',
            'events' => array(
                'created' => 'Created',
                'updated' => 'Updated',
                'comment_created' => 'CommentCreated',
            ),
        ),
        'pullrequest' => array(
            'folder' => 'pullrequest',
            'events' => array(
                'created' => 'Created',
                'updated' => 'Updated',
                'aproved' => 'Aproved',
                'unaproved' => 'Unaproved',
                'fulfilled' => 'Fulfilled',
                'rejected' => 'Rejected',
                'comment_created' => 'CommentCreated',
                'comment_deleted' => 'CommentDeleted',
            ),
        ),
    );

    public function setDocumentRoot($document_root)
    {
        $this->document_root = $document_root;
        return $this;
    }

    public function load($event)
    {
        $parser_file = $this->document_root . '/'
            . $this->event_keys[$event['event_class']]['folder'] . '/'
            . $this->event_keys[$event['event']] . '.php';
        if (!file_exists($parser_file)) {
            throw new Exception('No parser available for event ' . $event);
        }
        require_once self::DEFAULT_PARSER_FILE;
        require_once $this->document_root . '/' . $parser_file;
        $class_name = $this->event_keys[$event['event_class']]['events'][$event['event']];
        return new $class_name;
    }
}
