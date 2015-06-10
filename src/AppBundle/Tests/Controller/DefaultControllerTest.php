<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(1, $crawler->filter('html:contains("Homepage")')->count());
    }

    public function seriesIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/series');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
