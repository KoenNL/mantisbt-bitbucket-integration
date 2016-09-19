<?php

namespace Factory;

use Entity\Repository;
use Tools\Validator;
use Factory\ProjectFactory;
use Factory\UserFactory;
use Exception\InvalidDataException;

class RepositoryFactory
{

    private static $required_data = array(
        'type' => true,
        'name' => true,
        'full_name' => true,
        'uuid' => true,
        'links' => false,
        'project' => true,
        'website' => false,
        'owner' => true,
        'scm' => true,
        'is_private' => true
    );

    /**
     * Create new Entity\Repository from Repository payload.
     * @param array $data formatted Repository payload.
     * @return Entity\Repository
     * @link https://confluence.atlassian.com/bitbucket/event-payloads-740262817.html#EventPayloads-entity_user BitBucket payload
     * @throws InvalidDataException
     */
    public static function createRepository(array $data)
    {
        if (!Validator::validateArray($data, self::$required_data)) {
            throw new InvalidDataException('Invalid data supplied in ' . __METHOD__);
        }

        $repository = new Repository;

        $repository->setType($data['type'])
            ->setName($data['name'])
            ->setFullName($data['full_name'])
            ->setUuid($data['uuid']);
        if (!empty($data['links'])) {
            $repository->setLinks($data['links']);
        }
        
        $repository->setProject(ProjectFactory::createProject($data['project']));
        
        if (!empty($data['website'])) {
            $repository->setWebsite($data['website']);
        }
        
        $repository->setOwner(UserFactory::createUser($data['owner']))
            ->setScm($data['scm'])
            ->setIsPrivate($data['is_private']);

        return $repository;
    }
}
