<?php


namespace App\Tests\IntegrationTests\Data;

use App\Infrastructure\Test\IntegrationTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetDataForDateTest
 * @package App\Tests\IntegrationTests\Data
 */
class GetDataForDateTest extends IntegrationTestCase
{
    const URL = '/event';

    public function testSuccessful()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, self::URL, [
            'date' => '2020-12-01',
            'keyword' => 'love'
        ]);
        $this->assertResponseIsSuccessful();
    }

}
