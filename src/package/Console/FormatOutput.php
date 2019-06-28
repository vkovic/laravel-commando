<?php

namespace Vkovic\LaravelCommandos\Console;

trait FormatOutput
{
    /**
     * Force all output to be one space from beginning of the screen
     * for nicer output
     *
     * @param      $string
     * @param null $style
     * @param null $verbosity
     */
    public function line($string, $style = null, $verbosity = null)
    {
        parent::line(' ' . $string . ' ', $style, $verbosity);
    }

    /**
     * Make one empty line
     *
     * @return $this
     */
    public function skipLine()
    {
        parent::line('');

        return $this;
    }

    /**
     * Skip one line at the end of each finished command
     */
    public function __destruct()
    {
        if ($this->output !== null) {
            $this->skipLine();
        }
    }
}
