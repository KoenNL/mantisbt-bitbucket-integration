<?php

namespace Entity;

use Entity\Repository;

class Branch
{
    
    private $name;
    private $commit;
    private $repository;
    
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setCommit($commit)
    {
        $this->commit = $commit;
        
        return $this;
    }
    
    public function getCommit()
    {
        return $this->commit;
    }
    
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;
        
        return $this;
    }
    
}