<?php

namespace Factory;

use Entity\PullRequest;
use Factory\UserFactory;
use Factory\BranchFactory;
use Tools\Validator;
use Exception\InvalidDataException;
use \DateTime;

class PullRequestFactory
{
    
    private static $required_data = array(
        'id' => true,
        'title' => true,
        'description' => true,
        'state' => true,
        'author' => true,
        'source' => true,
        'destination' => true,
        'merge_commit' => true,
        'participants' => true,
        'reviewers' => true,
        'close_source_branch' => true,
        'closed_by' => false,
        'reason' => false,
        'created_on' => true,
        'updated_on' => false,
        'links' => false
    );
    
    /**
     * Create a new Entity\PullRequest from a PullRequest payload.
     * @param array $data formatted array with PullRequest payload.
     * @return Entity\PullRequest
     * @link https://confluence.atlassian.com/bitbucket/event-payloads-740262817.html#EventPayloads-entity_user BitBucket payload
     * @throws InvalidDataException
     */
    public static function createPullRequest(array $data)
    {
        if (!Validator::validateArray($data, self::$required_data)) {
            throw new InvalidDataException('Invalid data supplied in ' . __METHOD__);
        }
        
        $pull_request = new PullRequest;
        
        $pull_request->setId($data['id'])
            ->setTitle($data['title'])
            ->setDescription($data['description'])
            ->setState($data['state'])
            ->setAuthor(UserFactory::createUser($data['author']))
            ->setSource(BranchFactory::createBranch($data['source']))
            ->setDestination(BranchFactory::createBranch($data['destination']))
            ->setMergeCommit($data['merge_commit']);
        
        foreach ($data['participants'] as $participant) {
            $pull_request->addParticipant(UserFactory::createUser($participant));
        }
        
        foreach ($data['reviewers'] as $reviewer) {
            $pull_request->addReviewer(UserFactory::createUser($reviewer));
        }
        
        $pull_request->setCloseSourceBranch($data['close_source_branch']);
        
        if (!empty($data['closed_by'])) {
            $pull_request->setClosedBy(UserFactory::createUser($data['closed_by']));
        }
        
        if (!empty($data['reason'])) {
            $pull_request->setReason($data['reason']);
        }
        
        $pull_request->setCreatedOn(new DateTime($data['created_on']));
        
        if (!empty($data['updated_on'])) {
            $pull_request->setUpdatedOn(new DateTime($data['updated_on']));
        }
        
        if (!empty($data['links'])) {
            $pull_request->setLinks($data['links']);
        }
        
        return $pull_request;
    }
    
}