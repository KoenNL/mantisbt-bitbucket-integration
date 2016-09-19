<?php

namespace Factory;

use Entity\User;
use Tools\Validator;

class UserFactory
{
    
    private static $required_data = array(
        'type' => true,
        'username' => true,
        'display_name' => true,
        'uuid' => true,
        'links' => false,
    );
    
    /**
     * Create a new Entity\User from Owner payload
     * @param array $data formatted array with Owner payload
     * @link https://confluence.atlassian.com/bitbucket/event-payloads-740262817.html#EventPayloads-entity_user BitBucket payload
     * @return Entity\User
     * @throws InvalidDataException
     */
    public static function createUser(array $data)
    {
        if (!Validator::validateArray($data, self::$required_data)) {
            throw new InvalidDataException('Invalid data supplied in ' . __METHOD__);
        }
        
        $user = new User;
        
        $user->setType($data['type'])
            ->setUsername($data['username'])
            ->setDisplayName($data['display_name'])
            ->setUuid($data['uuid']);
        
        if (!empty($data['links'])) {
            $user->setLinks($data['links']);
        } 
        
        return $user;
    }
    
}