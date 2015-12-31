<?php namespace TechExim\Support\Testing;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\CrawlerTrait;

trait Crawler
{
    use CrawlerTrait;

    /**
     * Call the given URI and return the Response.
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $parameters
     * @param  array  $cookies
     * @param  array  $files
     * @param  array  $server
     * @param  string $content
     * @return \Illuminate\Http\Response
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');

        $this->currentUri = $this->prepareUrlForRequest($uri);

        $this->beforeRequest($method, $uri, $parameters, $cookies, $files, $server, $content);

        $request = Request::create(
            $this->currentUri, $method, $parameters,
            $cookies, $files, array_replace($this->serverVariables, $server), $content
        );

        $request  = $this->beforeHandleRequest($request);
        $response = $this->afterHandleRequest($kernel->handle($request));

        $kernel->terminate($request, $response);

        return $this->response = $response;
    }

    /**
     * @param       $method
     * @param       $uri
     * @param array $parameters
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null  $content
     */
    protected function beforeRequest($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [],
                                     $content = null)
    {
        // do something
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function beforeHandleRequest(Request $request)
    {
        return $request;
    }

    protected function afterHandleRequest($response)
    {
        return $response;
    }
}