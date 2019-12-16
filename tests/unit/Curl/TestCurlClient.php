<?php



class TestCurlClient extends \PHPUnit\Framework\TestCase
{

    /**
     * Test get method.
     */
    public function testGet()
    {
        $client = new \WPDesk\HttpClient\Curl\CurlClient();
        $response = $client->get('https://www.google.com', '', array(), 15);
        $this->assertInstanceOf(\WPDesk\HttpClient\HttpClientResponse::class, $response);
        $this->assertEquals(200, $response->getResponseCode());
    }

    /**
     * Test post method.
     */
    public function testPost()
    {
        $client = new \WPDesk\HttpClient\Curl\CurlClient();
        $response = $client->post('https://www.google.com', '', array(), 15);
        $this->assertInstanceOf(\WPDesk\HttpClient\HttpClientResponse::class, $response);
        $this->assertEquals(405, $response->getResponseCode());
    }

    /**
     * Test put method.
     */
    public function testPut()
    {
        $client = new \WPDesk\HttpClient\Curl\CurlClient();
        $response = $client->put('https://www.google.com', '', array(), 15);
        $this->assertInstanceOf(\WPDesk\HttpClient\HttpClientResponse::class, $response);
        $this->assertEquals(405, $response->getResponseCode());
    }

    /**
     * Test delete method.
     */
    public function testDelete()
    {
        $client = new \WPDesk\HttpClient\Curl\CurlClient();
        $response = $client->put('https://www.google.com', '', array(), 15);
        $this->assertInstanceOf(\WPDesk\HttpClient\HttpClientResponse::class, $response);
        $this->assertEquals(405, $response->getResponseCode());
    }

}