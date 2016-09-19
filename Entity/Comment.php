<?php

namespace Entity;

use \DateTime;

class Comment
{

    private $id;
    private $parent;
    private $content = array(
        'raw' => '',
        'html' => '',
        'markup' => '',
    );
    private $inline = array(
        'path' => '',
        'from' => '',
        'to' => '',
    );
    private $created_on;
    private $updated_on;
    private $links = array(
        'self' => '',
        'html' => '',
    );
    private $available_content = array(
        'raw',
        'html',
        'markup',
    );
    private $available_inline = array(
        'path',
        'from',
        'to',
    );

    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setParent($parent)
    {
        $this->parent = (int) $parent;

        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setContent($content, $type = null)
    {
        if (!empty($type) && in_array($type, $this->available_content)) {
            $this->content[$type] = $content;
        } elseif (is_array($content)) {
            $this->content = $content;
        }

        return $this;
    }

    public function getContent($type = null)
    {
        if (!empty($type) && in_array($type, $this->available_content)) {
            return $this->content[$type];
        }

        return $this->content;
    }

    public function setInline($inline, $type = null)
    {
        if (!empty($type) && in_array($type, $this->available_inline)) {
            $this->inline[$type] = $inline;
        } elseif (is_array($inline)) {
            $this->inline = $inline;
        }

        return $this;
    }

    public function getInline($type = null)
    {
        if (!empty($type) && in_array($type, $this->available_inline)) {
            return $this->inline[$type];
        }

        return $this->inline;
    }
    
    public function setCreatedOn(DateTime $created_on)
    {
        $this->created_on = $created_on;
        
        return $this;
    }
    
    public function getCreatedOn()
    {
        return $this->created_on;
    }
    
    public function setUpdatedOn(DateTime $updated_on)
    {
        $this->updated_on = $updated_on;
        
        return $this;
    }
    
    public function getUpdatedOn()
    {
        return $this->updated_on;
    }
    
    public function setLinks(array $links)
    {
        $this->links = $links;
        
        return $this;
    }
    
    public function getLinks()
    {
        return $this->links;
    }
}
