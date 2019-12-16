<?php

namespace Tests;

use WPDesk\Forms\AbstractForm;
use WPDesk\Forms\ConditionalFormInterface;
use WPDesk\Forms\FormsCollection;

class TestHttpClientFactory extends \PHPUnit\Framework\TestCase
{

	private $anonymousClass;

	protected function setUp(){
		// Create a new instance from the Abstract Class
		$this->anonymousClass = new class extends AbstractForm {
			// Just a sample public function that returns this anonymous instance
			protected function create_form_data()
			{
				return array('test' => true);
			}
		};


	}

    /**
     * Test createClient method.
     */
    public function testCreateClient()
    {
        $options = Mockery::mock(\WPDesk\HttpClient\HttpClientOptions::class);
        $options->shouldReceive('getHttpClientClass')
            ->withAnyArgs()
            ->andReturn(\WPDesk\HttpClient\Curl\CurlClient::class);
        $factory = new \WPDesk\HttpClient\HttpClientFactory();
        $client = $factory->createClient($options);
        $this->assertInstanceOf(\WPDesk\HttpClient\Curl\CurlClient::class, $client);
    }


}