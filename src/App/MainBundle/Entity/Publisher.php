<?php

namespace App\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publisher
 */
class Publisher
{
    public function __toString(){
        return $this->published;
    }

    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var \DateTime
     */
    private $publish;


    /**
     * Set publish
     *
     * @param \DateTime $publish
     * @return Publisher
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Get publish
     *
     * @return \DateTime 
     */
    public function getPublish()
    {
        return $this->publish;
    }
    /**
     * @var \DateTime
     */
    private $published;

    /**
     * @var string
     */
    private $edition;


    /**
     * Set published
     *
     * @param \DateTime $published
     * @return Publisher
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return \DateTime 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set edition
     *
     * @param string $edition
     * @return Publisher
     */
    public function setEdition($edition)
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * Get edition
     *
     * @return string 
     */
    public function getEdition()
    {
        return $this->edition;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $book;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->book = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add book
     *
     * @param \App\MainBundle\Entity\Book $book
     * @return Publisher
     */
    public function addBook(\App\MainBundle\Entity\Book $book)
    {
        $this->book[] = $book;

        return $this;
    }

    /**
     * Remove book
     *
     * @param \App\MainBundle\Entity\Book $book
     */
    public function removeBook(\App\MainBundle\Entity\Book $book)
    {
        $this->book->removeElement($book);
    }

    /**
     * Get book
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBook()
    {
        return $this->book;
    }
}
