<?php

namespace XString;

trait Format {

    /**
     * ExpandTabs can expand tabs ('\t') rune in str to one or more spaces dpending on
     * For example, CJK characters will be treated as two characters.
     *
     *
     * @param integer $tabSize Size of tab.
     *
     * @return string
     * @throws \Exception Excepcion if the size is not greater than 0.
     */
    public function expandTabs($tabSize)
    {
        if ($tabSize <= 0) {
            throw new \Exception('The size of the tab expansion has to be greater than 0');
        }

        $output = null;
        $column = 0;
        $orig = $this->str;
        // TODO: Fix the case for Kanjis. In the example of this url it's the solution for how iterate in
        // a string of encoded in utf-8 chars.
        //http://php.net/manual/en/function.mb-strwidth.php
        for ($i = 0; $i<mb_strlen($this->str, 'UTF-8'); $i++) {
            $rune = $this->str[$i];
            if ($rune == "\t") {
                $expand = $tabSize - $column%$tabSize;
                for ($j = 0; $j< $expand; $j++) {
                    $output .= ' ';
                }
                $column += $expand+1;
                $i++;
            } else {
                if ($rune == "\n") {
                    $column = 0;
                } else {
                    $column += $this->numBytesOfRune($this->str[$i]);
                }
            }

            $output .= $this->str[$i];
        }

        if (is_null($output)) {
            return $this->str;
        }

        return $output;
    }

    /**
     * leftJustify returns a string with pad string at right side if str's rune length is smaller than length. If str's rune length is larger than length, str itself will be returned.
     * If pad is an empty string, str will be returned.
     *
     * @param integer $size    Size of the string.
     * @param string  $content Content to fill with.
     *
     * @return void
     */
    public function leftJustify($size, $content)
    {
       // TODO: Implement
    }

    /**
     * RightJustify returns a string with content string at left side if str's rune length is smaller than length. If str's rune length is larger than length, str itself will be returned.
     * If content is an empty string, str will be returned.
     *
     * @param integer $size    Size for justify.
     * @param string  $content String for make the justification.
     *
     *  @return XString
     */
    public function rightJustify($size, $content)
    {
        if (mb_strlen($this->str, 'UTF-8') >= $size) {
            return $this->str;
        }

        $prefix = '';
        while ((mb_strlen($this->str, 'UTF-8') + mb_strlen($prefix, 'UTF-8')) < $size) {
            if ($size - (mb_strlen($this->str, 'UTF-8') + mb_strlen($prefix, 'UTF-8'))  >  mb_strlen($content, 'UTF-8')) {
                $prefix .= $content;
            } else {
                $currentSize = mb_strlen($prefix, 'UTF-8') + mb_strlen($this->str, 'UTF-8');
                $restContent = mb_substr($content, 0, $size- $currentSize);
                $prefix .= $restContent;
            }
        }
        $this->str = $prefix.$this->str;

        return $this;
    }

    /**
     * Center returns a string with pad string at both side if str's rune length is smaller than length. If str's rune length is larger than length, str itself will be returned.
     * If pad is an empty string, str will be returned.
     *
     * @param integer $size    Size.
     * @param string  $content Content.
     *
     * @return XString
    */
    public function center($size, $content = ' ')
    {
        $tmpStr = $this->str;
        for ($i = 0; $i<$size; $i++) {
            $tmpStr = $content.$tmpStr.$content;
        }
        $this->str = $tmpStr;

        return $this;
    }

}
