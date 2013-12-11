<?php

namespace ck\RecipesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IngredientControllerTest extends WebTestCase
{
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'test_user',
            'PHP_AUTH_PW'   => 'test_pwd',
        ));

        // Create a new entry in the database
        $crawler = $client->request('GET', '/ingredients');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /ingredients");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('ingredient_submit')->form(array(
            'ingredient[name]'   => 'Rhum 3 Rivières',
            'ingredient[volume]' => '50'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Rhum 3 Rivières")')->count(), 'Missing element td:contains("Rhum 3 Rivières")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('ingredient_submit')->form(array(
            'ingredient[name]'   => 'L\'île du paradis',
            'ingredient[volume]' => '70'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "L\'île du paradis"
        $this->assertGreaterThan(0, $crawler->filter('[value="L\'île du paradis"]')->count(), 'Missing element [value="L\'île du paradis"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/L\'île du paradis/', $client->getResponse()->getContent());
    }
}
