<?php

namespace Factory;

use Entity\Branch;
use Factory\RepositoryFactory;
use Tools\Validator;
use Exception\InvalidDataException;

class BranchFactory
{

    private static $required_data = array(
        'branch' => array(
            'name' => true
        ),
        'commit' => array(
            'hash' => true
        ),
        'repository' => true
    );
    
    /**
     * Create new Entity\Branch from PullRequest/source or PullRequest/destination payload.
     * @param array $data formatted array with PullRequest/source or PullRequest/destination payload.
     * @return Entity\Branch
     * @link https://confluence.atlassian.com/bitbucket/event-payloads-740262817.html#EventPayloads-entity_user BitBucket payload
     * @throws InvalidDataException
     */
    public static function createBranch(array $data)
    {
        if (!Validator::validateArray($data, self::$required_data)) {
            throw new InvalidDataException('Invalid data supplied in ' . __METHOD__);
        }
        
        $branch = new Branch;

        $branch->setName($data['branch']['name'])
            ->setCommit($data['commit']['hash'])
            ->setRepository(RepositoryFactory::createRepository($data['repository']));

        return $branch;
    }
}
