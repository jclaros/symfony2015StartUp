<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MovieRepository")
 */
class Movie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    
    protected $year;
    
    /**
     * @var string
     * @ORM\Column(type="boolean")
     */
    
    protected $borrowed;
    
    
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
     * 
     * @return String
     */
    public function getTitle(){
      return $this->title;
    }
    
    /**
     * 
     * @param String $title
     */
    public function setTitle($title){
      $this->title = $title;
    }
    
    /**
     * 
     * @return int
     */
    public function getYear(){
      return $this->year;
    }
    
    /**
     * 
     * @param int $year
     */
    public function setYear($year){
      $this->year = $year;
    }
    
    /**
     * 
     * @return Boolean
     */
    public function getBorrowed(){
      return $this->borrowed;
    }
    
    /**
     * 
     * @param boolean $flag
     */
    public function setBorrowed($flag){
      $this->borrowed = $flag;
    }
    
}
