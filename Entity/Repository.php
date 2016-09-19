<?php

namespace Entity;

use Entity\User;
use Entity\Project;
use Exception\NotSupportedException;

class Repository
{

    private $type;
    private $name;
    private $full_name;
    private $uuid;
    private $links = array();
    private $project;
    private $website;
    private $owner;
    private $scm;
    private $is_private;
    private $available_scm = array('git' => 'git', 'hg' => 'mercurial');

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

    public function setFullName($full_name)
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getFullName()
    {
        return $this->full_name;
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

    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setScm($scm)
    {
        if (empty($this->available_scm[strtolower($scm)])) {
            throw new NotSupportedException('SCM ' . $scm . ' is currently not supported. '
            . 'Currently only ' . implode(', ', $this->available_scm)
            . ' are supported with the respective keys: '
            . implode(', ', arra_keys($this->available_scm)) . '.');
        }

        $this->scm = strtolower($scm);

        return $this;
    }

    public function getScm()
    {
        return $this->scm;
    }

    public function setIsPrivate($is_private)
    {
        $this->is_private = $is_private;

        return $this;
    }

    public function getIsPrivate()
    {
        return $this->is_private;
    }
}
