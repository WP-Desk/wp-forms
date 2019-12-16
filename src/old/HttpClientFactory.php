<?php

namespace WPDesk\HttpClient;


class HttpClientFactory
{
    /**
     * @param HttpClientOptions $options
     * @return HttpClient
     */
    public function createClient(HttpClientOptions $options)
    {
        $className = $options->getHttpClientClass();
        return new $className;
    }
}