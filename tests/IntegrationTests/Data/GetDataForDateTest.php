<?php


namespace App\Tests\IntegrationTests\Data;

use App\Infrastructure\Test\IntegrationTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Yousign\Domain\Data\Entity\Commit;

/**
 * Class GetDataForDateTest
 * @package App\Tests\IntegrationTests\Data
 */
class GetDataForDateTest extends IntegrationTestCase
{
    const URL = '/event';

    public function testSuccessful()
    {
        $date = '2020-12-01';
        $keyword = 'love';
        $client = static::createClient();
        $client->request(Request::METHOD_POST, self::URL, [
            'date' => $date,
            'keyword' => $keyword
        ]);
        $this->assertResponseIsSuccessful();
        $responseDecoded = json_decode($client->getResponse()->getContent());
        $content = $responseDecoded->content;
        $this->assertEquals(Response::HTTP_OK, $responseDecoded->code);
        $this->assertEquals($date, $content->date);
        $this->assertEquals($keyword, $content->keyword);
        $this->assertEquals(1, $content->total);
        $pushEvent = Commit::PUSH_EVT;
        $this->assertEquals(1, $content->dataByEventType->$pushEvent->total);
        $this->assertEquals(1, $content->dataByEventType->$pushEvent->{23});
        $this->assertEquals(1, count($content->lastCommits));
        $this->assertEquals("12345", $content->lastCommits[0]->commitId);
        $this->assertEquals("myrepo/myrepo", $content->lastCommits[0]->repositoryName);
        $this->assertEquals("repoURL", $content->lastCommits[0]->repositoryUrl);
        $this->assertEquals("Lots of fun and lots of love", $content->lastCommits[0]->message);
    }

    public function testSuccessfulWithNoData()
    {
        $date = '2020-12-01';
        $keyword = 'nodata';
        $client = static::createClient();
        $client->request(Request::METHOD_POST, self::URL, [
            'date' => $date,
            'keyword' => $keyword
        ]);
        $this->assertResponseIsSuccessful();
        $responseDecoded = json_decode($client->getResponse()->getContent());
        $content = $responseDecoded->content;
        $this->assertEquals(Response::HTTP_OK, $responseDecoded->code);
        $this->assertEquals($date, $content->date);
        $this->assertEquals($keyword, $content->keyword);
        $this->assertEquals(0, $content->total);
    }

}
