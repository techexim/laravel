<?php namespace TechExim\Support\Testing;

use ErrorException;

trait JsonAssertions
{
    /**
     * Assert JSON content with regular expression
     *
     * <code>
     * $this->seeJsonRegExp([
     *     'error' => true,
     *     'code'  => '/^\d+$/i'
     * ]);
     * </code>
     * @param array $expected
     * @param mixed $data if it is not specified, use json response instead
     */
    public function seeJsonRegExp(array $expected, $data = null)
    {
        if (is_null($data)) {
            $data = $this->getJsonResponse();
        }

        foreach ($expected as $key => $value) {
            if (!isset($data->$key)) {
                $this->assertFalse(true, "$key does not exist in response");
            }

            $actual = $data->$key;
            if (is_array($value)) {
                $this->seeJsonRegExp($value, $actual);
            } else if (is_bool($value)) {
                if ($value) {
                    $this->assertTrue($actual);
                } else {
                    $this->assertFalse($actual);
                }
            } else if (is_string($value)) {
                try {
                    $this->assertRegExp($value, (string) $actual);
                } catch (ErrorException $e) {
                    $this->assertEquals($value, $actual);
                }
            } else {
                $this->assertEquals($value, $actual);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getJsonResponse()
    {
        return property_exists($this, 'response') ? json_decode($this->response->getContent()) : null;
    }
}