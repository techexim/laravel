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
     * @param array  $expected
     * @param mixed  $data if it is not specified, use json response instead
     * @param string $message
     */
    public function seeJsonRegExp(array $expected, $data = null, $message = null)
    {
        if (is_null($data)) {
            $data = $this->getJsonResponse();
        }

        foreach ($expected as $key => $value) {
            if (is_array($data)) {
                if (isset($data[$key])) {
                    $actual = $data[$key];
                } else {
                    $this->assertFalse(true, "$key does not exist in array.");
                }
            } elseif (is_object($data)) {
                if (isset($data->$key)) {
                    $actual = $data->$key;
                } else {
                    $this->assertFalse(true, "$key does not exist in object.");
                }
            } else {
                $this->assertFalse(true, "Input data must be an array or object.");
                continue;
            }

            if (is_array($value)) {
                $this->seeJsonRegExp($value, $actual, $message);
            } else if (is_bool($value)) {
                if ($value) {
                    $this->assertTrue($actual, $message);
                } else {
                    $this->assertFalse($actual, $message);
                }
            } else if (is_string($value)) {
                try {
                    $this->assertRegExp($value, (string) $actual, $message);
                } catch (ErrorException $e) {
                    $this->assertEquals($value, $actual, $message);
                }
            } else {
                $this->assertEquals($value, $actual, $message);
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