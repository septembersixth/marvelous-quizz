<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Question
 * @package Application\Entity
 * @ORM\Entity(repositoryClass="Application\Repository\Question")
 * @ORM\Table(name="questions")
 */
class Question
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $text;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Application\Entity\Option", mappedBy="question", cascade={"persist"})
     */
    protected $options;

    /**
     * @var \Application\Entity\Test
     * @ORM\ManyToOne(targetEntity="Application\Entity\Test", inversedBy="questions")
     */
    protected $test;

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
        $this->options = new ArrayCollection;
        $this->created = date_create();
    }

    public function __clone()
    {
        $this->options = new ArrayCollection;
        $this->created = date_create();
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
     * @return ArrayCollection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $options
     * @return $this
     */
    public function setOptions(Option $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return $this|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param Test $test
     * @return $this
     */
    public function setTest(Test $test = null)
    {
        $this->test = $test;
        return $this;
    }

    /**
     * @param Collection $options
     */
    public function addOptions(ArrayCollection $options)
    {
        foreach ($options as $option) {
            $option->setQuestion($this);
            $this->options[] = $option;
        }
    }

    /**
     * @param Collection $options
     */
    public function removeOptions(Collection $options)
    {
        /*
        foreach ($options as $option) {
            $option->setQuestion(null);
            $this->options->removeElement($option);
        }
        */
    }

}