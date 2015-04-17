<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Test
 * @package Application\Entity
 * @ORM\Entity(repositoryClass="Application\Repository\Test")
 * @ORM\Table(name="tests")
 */
class Test
{
    const LEVEL_EASY            = 1;
    const LEVEL_INTERMEDIARY    = 2;
    const LEVEL_HARD            = 3;

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
     * @ORM\OneToMany(targetEntity="Application\Entity\Question", mappedBy="test", cascade={"persist"})
     */
    protected $questions;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Application\Entity\Tag")
     */
    protected $tags;

    /**
     * @var Array
     * @ORM\Column(type="simple_array", nullable=true)
     */
    protected $level;

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
        foreach ($this->questions as $question) {
            $question->setDeleted(true);
        }

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
     * @param $image
     * @return $this
     */
    public function setImage($image)
    {
        if (empty($image['error'])) {
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

    /**
     * @param Collection $questions
     */
    public function addQuestions(ArrayCollection $questions)
    {
        foreach ($questions as $question) {
            $question->setTest($this);
            $this->questions[] = $question;
        }
    }

    /**
     * @param Collection $questions
     */
    public function removeQuestions(Collection $questions)
    {
        foreach ($questions as $question) {
            $question->setTest(null);
            $question->setDeleted(true);
            $this->questions->removeElement($question);
        }
    }

    /**
     * @param Collection $tags
     */
    public function addTags(Collection $tags)
    {
        foreach ($tags as $tag) {
            $this->tags->add($tag);
        }
    }

    /**
     * @param Collection $tags
     */
    public function removeTags(Collection $tags)
    {
        foreach ($tags as $tag) {
            $this->tags->removeElement($tag);
        }
    }

    /**
     * @return array
     */
    public function getQuestionsText()
    {
        $result = [];
        foreach($this->questions as $question) {
            $result[] = $question->getText();
        }

        return $result;
    }

    public function getSolutionsToArray()
    {
        $result = [];
        foreach($this->questions as $question) {
            $result = array_merge($result, $question->getSolutionstoArray());
        }
        return $result;
    }

    public function getQuestionsToArray()
    {
        $result = [];
        foreach($this->questions as $question) {
            $result[] = $question->toArray();
        }

        return $result;
    }

    public function toArray()
    {
        return [
            'hash'          => $this->hash,
            'image'         => $this->image,
            'explanation'   => $this->explanation,
            'questions'     => $this->getQuestionsToArray(),
            'solutions'     => $this->getSolutionsToArray(),
        ];
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param string $level
     * @return $this
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }
}