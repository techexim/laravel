<?php namespace TechExim\Support\Testing;

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
     * @param array      $expected
     * @param array|null $data if it is not specified, use json response instead
     */
    public function seeJsonRegExp(array $expected, array $data = null)
    {
        if (is_null($data)) {
            $data = json_decode($this->response->getContent(), true);
        }

        foreach ($expected as $key => $value) {
            if (!isset($data[$key])) {
                $this->assertFalse(true, "$key does not exist in response");
            }

            $actual = $data[$key];
            if (is_array($value)) {
                $this->seeJsonRegExp($value, $actual);
            } else if (is_bool($value)) {
                if ($value) {
                    $this->assertTrue($actual);
                } else {
                    $this->assertFalse($actual);
                }
            } else if (is_string($value)) {
                $this->assertRegExp($value, (string) $actual);
            } else {
                $this->assertEquals($value, $actual);
            }
        }
    }
}