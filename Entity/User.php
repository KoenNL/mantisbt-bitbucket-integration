<?php

namespace Entity;

class User
{
    
    private $type;
    private $username;
    private $display_name;
    private $uuid;
    private $links = array();
    
    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setUsername($username)
    {
        $this->username = $username;
        
        return $this;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function setDisplayName($display_name)
    {
        $this->display_name  = $display_name;
        
        return $this;
    }
    
    public function getDisplayName()
    {
        return $this->display_name;
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
        
        return $this->links[$name];
    }
    
}