<?php namespace TechExim\Console;

class Decorator
{
    protected $foreground_colors = array(
        'black'        => '0;30',
        'dark_gray'    => '1;30',
        'red'          => '0;31',
        'light_red'    => '1;31',
        'green'        => '0;32',
        'light_green'  => '1;32',
        'brown'        => '0;33',
        'yellow'       => '1;33',
        'blue'         => '0;34',
        'light_blue'   => '1;34',
        'purple'       => '0;35',
        'light_purple' => '1;35',
        'cyan'         => '0;36',
        'light_cyan'   => '1;36',
        'light_gray'   => '0;37',
        'white'        => '1;37'
    );

    protected $background_colors = array(
        'black'      => '40',
        'red'        => '41',
        'green'      => '42',
        'yellow'     => '43',
        'blue'       => '44',
        'magenta'    => '45',
        'cyan'       => '46',
        'light_gray' => '47'
    );

    // Returns colored string
    protected function getColoredString($string, $foreground_color = null,
                                        $background_color = null)
    {
        $colored_string = "";

        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }

        // Add string and end coloring
        $colored_string .= $string . "\033[0m";

        return $colored_string;
    }

    // Returns all foreground color names
    protected function getForegroundColors()
    {
        return array_keys($this->foreground_colors);
    }

    // Returns all background color names
    protected function getBackgroundColors()
    {
        return array_keys($this->background_colors);
    }

    public static function decorate($string, $foreground_color = null,
                                    $background_color = null)
    {
        return with(new static)->getColoredString($string, $foreground_color, $background_color);
    }
}