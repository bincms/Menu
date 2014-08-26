<?php

namespace Extension\Menu\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Tree(type="materializedPath", activateLocking=true)
 * @MongoDB\Document(repositoryClass="Extension\Menu\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @MongoDB\Id()
     */
    protected $id;

    /**
     * @Gedmo\Translatable()
     * @Gedmo\TreePathSource()
     * @MongoDB\String()
     */
    protected $title;

    /**
     * @MongoDB\String
     * @Gedmo\TreePath(separator="|", appendId=true)
     */
    protected $path;

    /**
     * @Gedmo\TreeLockTime()
     * @MongoDB\Field(type="date")
     */
    protected $lockTime;

    /**
     * @Gedmo\TreeLevel()
     * @MongoDB\Int()
     */
    protected $level;

    /**
     * @Gedmo\TreeParent()
     * @MongoDB\ReferenceOne(targetDocument="Menu")
     */
    protected $parent;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Menu", mappedBy="parent")
     */
    protected $children;

    /**
     * @MongoDB\String()
     */
    protected $url;

    /**
     * @MongoDB\Int()
     */
    protected $position;

    /**
     * @MongoDB\String()
     */
    protected $alias;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    public function getArrayPath()
    {
        $result = [];

        $items = explode('|', $this->getPath());

        foreach($items as $item) {
            if($item !== '') {
                $parts = explode('-', $item);
                if(sizeof($parts) == 2) {
                    $result[] = ['id' => $parts[1], 'title' => $parts[0]];
                }
            }
        }

        return $result;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getLockTime()
    {
        return $this->lockTime;
    }

    /**
     * @param mixed $lockTime
     */
    public function setLockTime($lockTime)
    {
        $this->lockTime = $lockTime;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param mixed $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }
} 