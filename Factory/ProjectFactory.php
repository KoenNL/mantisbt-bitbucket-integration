<?php

namespace Factory;

use Entity\Project;
use Tools\Validator;
use Exception\InvalidDataException;

class ProjectFactory
{
    
    private static $required_data = array(
        'type' => true,
        'name' => true,
        'uuid' => true,
        'links' => false,
        'key' => true
    );
    
    /**
     * Create a new Entity\Project from a Project payload.
     * @param array $data formatted array with Project payload.
     * @return Entity\Project
     * @link https://confluence.atlassian.com/bitbucket/event-payloads-740262817.html#EventPayloads-entity_user BitBucket payload
     * @throws InvalidDataException
     */
    public static function createProject(array $data)
    {
        if (!Validator::validateArray($data, self::$required_data)) {
            throw new InvalidDataException('Invalid data supplied in ' . __METHOD__);
        }
        
        $project = new Project;
        
        $project->setType($data['type'])
            ->setName($data['name'])
            ->setUuid($data['uuid']);
        
        if (!empty($data['links'])) {
            $project->setLinks($data['links']);
        }
        
        $project->setKey($data['key']);
        
        return $project;
    }
    
}