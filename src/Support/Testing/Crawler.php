<?php namespace TechExim\Support\Testing;

use Illuminate\Http\Request;

trait Crawler
{
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
        $resources = $this->prepareRequest($method, $uri, $parameters, $cookies, $files, $server, $content);
        list($method, $uri, $parameters, $cookies, $files, $server, $content) = $resources;

        $kernel           = $this->app->make('Illuminate\Contracts\Http\Kernel');
        $this->currentUri = $this->prepareUrlForRequest($uri);

        $request = Request::create(
            $this->currentUri, $method, $parameters,
            $cookies, $files, array_replace($this->serverVariables, $server), $content
        );

        $request  = $this->beforeRequest($request);
        $response = $this->afterRequest($kernel->handle($request));

        $kernel->terminate($request, $response);

        return $this->response = $response;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $parameters
     * @param array  $cookies
     * @param array  $files
     * @param array  $server
     * @param null   $content
     */
    protected function prepareRequest($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [],
                                      $content = null)
    {
        return [
            $method,
            $uri,
            $parameters,
            $cookies,
            $files,
            $server,
            $content
        ];
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function beforeRequest(Request $request)
    {
        return $request;
    }

    protected function afterRequest($response)
    {
        return $response;
    }
}