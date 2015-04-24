<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    protected $movieName;
    protected $movieId;
    public function __construct() {
      $this->movieName = rand(10, 1200000);
    }
    
    public function testGetMovies()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/movies.json');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(is_array(json_decode($client->getResponse()->getContent())));
    }
    
    public function testCreateMovie()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/movies.json', array(), array(), array(), '{"title": "Titanic'.$this->movieName.'", "year": 1990}');
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $movie = json_decode($client->getResponse()->getContent());
        $this->assertTrue(is_object($movie));
        if(is_object($movie)){
          $this->movieId = $movie->id;
        }
    }
    
    public function testEditData(){
        $client = static::createClient();
        $this->movieId = 10; 
        $crawler = $client->request('PUT', '/api/movies/'.$this->movieId.'.json', array(), array(), array(), '{"title": "Titanic'.$this->movieName.'", "year": 1990, "borrowed": true}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(is_object(json_decode($client->getResponse()->getContent())));
        $movie = json_decode($client->getResponse()->getContent());
        $this->assertEquals($movie->id, $this->movieId);
        $this->assertTrue($movie->borrowed === true);
    }
    
}
