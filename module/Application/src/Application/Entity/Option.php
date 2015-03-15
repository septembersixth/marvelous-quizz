<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Option
 * @package Application\Entity
 * @ORM\Entity
 * @ORM\Table(name="options")
 */
class Option
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
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $correct;

    /**
     * @var \Application\Entity\Question
     * @ORM\ManyToOne(targetEntity="Application\Entity\Question", inversedBy="options")
     */
    protected $question;

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

    /**
     * @return boolean
     */
    public function isCorrect()
    {
        return $this->correct;
    }

    /**
     * @param boolean $correct
     * @return $this
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;
        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \Datetime $created
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
     * @param boolean $deleted
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
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param Question $question
     * @return $this
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * @return string
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
} 