<?php

namespace Event\PullRequest;

use Event\DefaultParser;
use Factory\UserFactory;
use Factory\PullRequestFactory;
use Factory\RepositoryFactory;

class Created extends DefaultParser
{
    
    public function parse(array $payload)
    {
        $data = array(
            'actor' => UserFactory::createUser($payload['actor']),
            'pullrequest' => PullRequestFactory::createPullRequest($payload['pullrequest']),
            'repository' => RepositoryFactory::createRepository($payload['repository']),
        );
        
        $content = $this->processTemplate($data);
        $issue = $this->getIssue($data['repository']->getDescription());
        
        return $this->createComment($issue, $content);
    }
    
}