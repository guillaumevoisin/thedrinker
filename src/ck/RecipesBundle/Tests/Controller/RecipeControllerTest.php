<?php

namespace ck\RecipesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'test_user',
            'PHP_AUTH_PW'   => 'test_pwd',
        ));

        // Create a new entry in the database
        $crawler = $client->request('GET', '/recipes');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /recipes");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('recipe_submit')->form(array(
            'recipe[name]'  => 'Test'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('[value="Test"]')->count(), 'Missing element [value="Test"]');

        // Edit the entity

        $form = $crawler->selectButton('recipe_submit')->form(array(
            'recipe[name]'  => 'Foo'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('h1:contains("Foo")')->count(), 'Missing element Foo');

        // Delete the entity
        $client->submit($crawler->selectButton('form_submit')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    
}
