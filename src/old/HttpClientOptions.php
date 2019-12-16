<?php

namespace WPDesk\HttpClient;

interface HttpClientOptions
{
    /**
     * @return string
     */
    public function getHttpClientClass();
}