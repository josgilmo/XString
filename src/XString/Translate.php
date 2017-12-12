<?php

namespace XString;

trait Translate
{

    /**
     * Shuffle randomizes runes in a string and returns the result
     *
     * @param string $pattern Pattern to match.
     *
     * @return XString
     */
    public function squeeze($pattern)
    {
        $lastEncoding = mb_regex_encoding();
        mb_regex_encoding('UTF-8');
        if ($pattern == '') {
            $pattern = '(.)\1+';
            $result =  mb_ereg_replace($pattern, '\\1', $this->str, 'psr');
        } else {
            $pattern = '(['.$pattern.'])\1+';
            $result = mb_ereg_replace($pattern, '\\1', $this->str, 'psr');
        }
        mb_regex_encoding($lastEncoding);

        return $result;
    }
}
