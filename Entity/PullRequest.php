<?php

namespace Entity;

use Entity\Branch;
use Entity\User;
use Exception\NotSupportedException;
use \DateTime;

class PullRequest
{

    private $id;
    private $title;
    private $description;
    private $state;
    private $author;
    private $source;
    private $destination;
    private $merge_commit;
    private $participants = array();
    private $reviewers = array();
    private $close_source_branch;
    private $closed_by;
    private $reason;
    private $created_on;
    private $updated_on;
    private $links = array();
    private $available_states = array('open', 'merged', 'declined');

    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setState($state)
    {
        if (!in_array(strtolower($state), $this->available_states)) {
            throw new NotSupportedException('State ' . $state . ' is not supported. '
            . 'Currently only the states ' . implode(', ', $this->available_states)
            . ' are supported.');
        }
        $this->state = strtolower($state);

        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setSource(Branch $source)
    {
        $this->source = $source;

        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setDestination(Branch $destination)
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function setMergeCommit($merge_commit)
    {
        $this->merge_commit = $merge_commit;

        return $this;
    }

    public function getMergeCommit()
    {
        return $this->merge_commit;
    }

    public function addParticipant(User $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    public function setParticipants(array $participants)
    {
        foreach ($participants as $participant) {
            $this->addParticipant($participant);
        }

        return $this;
    }

    public function addReviewer(User $reviewer)
    {
        $this->reviewers[] = $reviewer;

        return $this;
    }

    public function setReviewers(array $reviewers)
    {
        foreach ($reviewers as $reviewer) {
            $this->addReviewer($reviewer);
        }

        return $this;
    }
    
    public function setCloseSourceBranch($close_source_branch)
    {
        $this->close_source_branch = $close_source_branch;
        
        return $this;
    }
    
    public function getCloseSourceBrnach()
    {
        return $this->close_source_branch;
    }
    
    public function setClosedBy(User $user)
    {
        $this->closed_by = $user;
        
        return $this;
    }
    
    public function getClosedBy()
    {
        return $this->closed_by;
    }
    
    public function setReason($reason)
    {
        $this->reason = $reason;
        
        return $this;
    }
    
    public function getReason()
    {
        return $this->reason;
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
    
    public function addLink($name, $link)
    {
        $this->links[$name] = $link;
        
        return $this;
    }
    
    public function setLinks(array $links)
    {
        foreach ($links as $name => $link) {
            $this->addLink($name, $link);
        }
        
        return $this;
    }
    
    public function getLink($name)
    {
        return $this->links[$name];
    }
    
    public function getLinks()
    {
        return $this->links;
    }
}
