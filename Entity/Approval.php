<?php

namespace Entity;

use Entity\User;
use \DateTime;

class Approval
{
    
    private $date;
    private $user;
    
    public function setDate(DateTime $date)
    {
        $this->date = $date;
        
        return $this;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setUser(User $user)
    {
        $this->user = $user;
        
        return $this;
    }
    
}