<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\NoteController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NoteControllerTest extends WebTestCase
{
    public function testGetNotes()
    {
        $client = static::createClient();

        $client->request('get', '/notes/');
        $response = $client->getResponse();

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        /** zwracany jest new Response, wiec chyba tak powinno byc */
        $this->assertContains('text/html', $response->headers->get('Content-Type'));

        $this->assertNotEmpty($client->getResponse()->getContent());
    }


}