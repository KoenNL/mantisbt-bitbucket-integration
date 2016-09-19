<?php

namespace Factory;

use Entity\Comment;
use Tools\Validator;
use \DateTime;
use Exception\InvalidDataException;

class CommentFactory
{

    private static $required_data = array(
        'id' => true,
        'parent' => true,
        'content' => true,
        'inline' => true,
        'created_on' => true,
        'updated_on' => false,
        'links' => false,
    );

    /**
     * Create new Entity\Comment from Comment payload.
     * @param array $data formatted array with Comment payload
     * @return Entity\Comment
     * @throws InvalidDateException
     * @link https://confluence.atlassian.com/bitbucket/event-payloads-740262817.html#EventPayloads-entity_comment BitBucket payload
     */
    public static function createComment(array $data)
    {
        if (!Validator::validateArray($data, self::$required_data)) {
            throw new InvalidDateException('Invalid input in ' . __METHOD__);
        }

        $comment = new Comment;

        $comment->setId($data['id'])
            ->setParent($data['parent']['id'])
            ->setContent($date['conten'])
            ->setInline($data['inline'])
            ->setCreatedOn(new DateTime($data['created_on']));

        if (!empty($data['updated_on'])) {
            $comment->setUpdatedOn(new DateTime($date['updated_on']));
        }
        if (!empty($data['links'])) {
            $comment->setLinks($data['links']);
        }
        
        return $comment;
    }
}
