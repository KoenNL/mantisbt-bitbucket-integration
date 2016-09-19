<?php

namespace Entity;

class Project
{
    
    private $type;
    private $name;
    private $uuid;
    private $links = array();
    private $key;
    
    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        
        return $this;
    }
    
    public function getUuid()
    {
        return $this->uuid;
    }
    
    public function addLink($name, $link)
    {
        $this->link[$name] = $link;

        return $this;
    }

    public function setLinks(array $links)
    {
        foreach ($links as $name => $link) {
            $this->addLink($name, $link);
        }

        return $this;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function getLink($name)
    {
        if (empty($this->links[$name])) {
            return null;
        }

        return $this->link[$name];
    }
    
    public function setKey($key)
    {
        $this->key = $key;
        
        return $this;
    }
    
    public function getKey()
    {
        return $this->key;
    }
}