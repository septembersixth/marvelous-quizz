<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Test
 * @package Application\Entity
 * @ORM\Entity
 * @ORM\Table(name="tests")
 */
class Test
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $hash;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $image;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $explanation;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Application\Entity\Question", mappedBy="test")
     */
    protected $questions;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Application\Entity\Tag")
     */
    protected $tags;

    /**
     * @var \Datetime
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $deleted = false;

    public function __construct()
    {
        $this->questions = new ArrayCollection;
        $this->tags = new ArrayCollection;
    }

    /**
     * @return \Datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param $deleted
     * @return $this
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return string
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

    /**
     * @param $explanation
     * @return $this
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $picture
     * @return $this
     */
    public function setImage($image)
    {
        if (empty($image['image']['error'])) {
            $this->image = substr(strrchr($image['tmp_name'], '/'), 1);
        }
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param $questions
     * @return $this
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param $tags
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

} 