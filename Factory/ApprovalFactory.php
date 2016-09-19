<?php

namespace Factory;

use Entity\Approval;
use Tools\Validator;
use Factory\UserFactory;
use Exception\InvalidDataException;
use \DateTime;

class ApprovalFactory
{
    
    private static $required_data = array(
        'date' => true,
        'user' => true,
    );
    
    /**
     * Create new Entity\Approval from Comment payload.
     * @param array $data formatted array with Approval payload
     * @return Entity\Comment
     * @throws InvalidDateException
     * @link https://confluence.atlassian.com/bitbucket/event-payloads-740262817.html#EventPayloads-Approved BitBucket payload
     */
    public static function createApproval(array $data)
    {
        if (!Validator::validateArray($data, self::$required_data)) {
            throw new InvalidDataException('Invalid data supplied in ' . __METHOD__);
        }
        
        $approval = new Approval;
        
        $approval->setDate(new DateTime($data['date']))
            ->setUser(UserFactory::createUser($data['user']));
        
        return $approval;
    }
    
}