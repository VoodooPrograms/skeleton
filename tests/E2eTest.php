<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class E2eTest extends WebTestCase
{
    public function testHelloActionSuccessful(): void
    {
        $client = $this->createClient();

        $client->request('GET', '/hello?name=Dawid');
//        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson(json_encode(['message' => "Hello Dawid!"]));
    }
}