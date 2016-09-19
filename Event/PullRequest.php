<?php

namespace Event;

use Event\DefaultParser;
use Factory\UserFactory;
use Factory\PullRequestFactory;
use Factory\RepositoryFactory;
use Factory\ApprovalFactory;
use Factory\CommentFactory;

class PullRequest extends DefaultParser
{
    public function parseCreated(array $payload)
    {
        $data = $this->prepareData($payload);
        $data['event'] = 'created';
        return $this->createComment($data);
    }
    
    public function parseUpdated(array $payload)
    {
        $data = $this->prepareData($payload);
        $data['event'] = 'updated';
        return $this->createComment($data);
    }
    
    public function parseApproved(array $payload)
    {
        $data = $this->prepareData($payload);
        $data['event'] = 'approved';
        $data['approval'] = ApprovalFactory::createApproval($payload['approval']);
        return $this->createComment($data);
    }

    public function parseApprovalRemoved(array $payload)
    {
        $data = $this->prepareData($payload);
        $data['event'] = 'approval removed';
        $data['approval'] = ApprovalFactory::createApproval($payload['approval']);
        return $this->createComment($data);
    }
    
    public function parseDeclined(array $payload)
    {
        $data = $this->prepareData($payload);
        $data['event'] = 'declined';
        return $this->createComment($data);
    }
    
    public function parseMerged(array $payload)
    {
        $data = $this->prepareData($payload);
        $data['event'] = 'merged';
        return $this->createComment($data);
    }
    
    public function parseCommentCreated(array $payload)
    {
        $data = $this->prepareData($payload);
        $data['event'] = 'comment created';
        $data['comment'] = CommentFactory::createComment($payload['comment']);
        return $this->createComment($data);
    }
    
    public function parseCommentUpdated(array $payload)
    {
        $data = $this->prepareData($payload);
        $data['event'] = 'comment updated';
        $data['comment'] = CommentFactory::createComment($payload['comment']);
        return $this->createComment($data);
    }
    
    public function parseCommentDeleted(array $payload)
    {
        $data = $this->prepareData($payload);
        $data['event'] = 'comment deleted';
        $data['comment'] = CommentFactory::createComment($payload['comment']);
        return $this->createComment($data);
    }
    
    private function prepareData(array $payload)
    {
        return array(
            'actor' => UserFactory::createUser($payload['actor']),
            'pullrequest' => PullRequestFactory::createPullRequest($payload['pullrequest']),
            'repository' => RepositoryFactory::createRepository($payload['repository']),
        );
    }

    private function createComment($data)
    {
        $content = $this->processTemplate($data);
        $issue = $this->getIssue($data['repository']->getDescription());

        return $this->createComment($issue, $content);
    }
}
