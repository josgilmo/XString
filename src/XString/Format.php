<?php

namespace XString;

trait Format
{

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
        for ($i = 0; $i<mb_strlen($this->str, 'UTF-8'); $i++) {
            $rune = mb_substr($this->str, $i, 1, 'UTF-8');
            if ($rune == "\t") {
                $expand = $tabSize - $column%$tabSize;
                for ($j = 0; $j< $expand; $j++) {
                    $output .= ' ';
                }
                $column += $expand;
            } else {
                if ($rune == "\n") {
                    $column = 0;
                } else {
                    $column += mb_strwidth($rune, 'UTF-8');
                }
            }
            if ($rune!="\t") {
                $output .= $rune;
            }
        }
        
        if (!is_null($output)) {
            return $output;
        }

        return $this->str;
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
    public function rightJustify($size, $pad)
    {
        if ($pad == "" || mb_strlen($this->str, 'UTF-8') >= $size) {
            return $this;
        }
        $remains = $size - mb_strlen($this->str, 'UTF-8');
        $padLen = mb_strlen($pad, 'UTF-8');
/*       
l := Len(str)

    if l >= length || pad == "" {
        return str
    }

    remains := length - l
    padLen := Len(pad)

    output := &bytes.Buffer{}
    output.Grow(len(str) + (remains/padLen+1)*len(pad))
    writePadString(output, pad, padLen, remains) 
*/
        $this->str = $this->padString($pad, $padLen, $remains) . $this->str;
/*
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
*/
        return $this;
    }


    private function padString( $pad, $padLen, $remains) {
        $output = ""; 
        $repeats  = floor($remains / $padLen);
        for($i=0;$i<$repeats; $i++){
            $output .= $pad;
        }

        $remains = $remains% $padLen;
        if ($remains!=0) {
            for ($i=0; $i< $remains; $i++) {
                $rune = mb_substr($pad, $i, 1, 'UTF-8');
                $output .=$rune;
            }
        }

        return $output;
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
    public function center($size, $pad = ' ')
    {
        $length = mb_strlen($this->str, 'UTF-8');  
        if ($length >= $size || $pad == "") {
            return $this->str;
        }

        $remains =  $size - $length;
        $padLen = mb_strlen($pad, 'UTF-8');

        $prefix = $this->padString($pad, $padLen, floor($remains/2));
        $suffix = $this->padString($pad, $padLen, floor(($remains+1)/2));
        $this->str = $prefix . $this->str . $suffix;

        return $this;
    }
}
