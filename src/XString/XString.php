<?php

namespace XString;

class XString
{
    protected $str;

    public function __construct($str, $encoding = 'UTF-8', $forceEncode = true)
    {
        if (mb_detect_encoding($str) != 'UTF-8' && $forceEncode) {
            $str = mb_convert_encoding($str, 'UTF-8');
        }
        $this->str = $str;
    }

    public function startWith($prefix)
    {
        return mb_substr($this->str, 0, mb_strlen($prefix)) === $prefix;
    }

    public function endWith($suffix)
    {
        return mb_substr($this->str, mb_strlen($this->str) - mb_strlen($suffix), mb_strlen($suffix) == $suffix);
    }

    public function center($size, $content = ' ')
    {
        $tmpStr = $this->str;
        for ($i = 0;$i<$size;$i++) {
            $tmpStr = $content.$tmpStr.$content;
        }
        $this->str = $tmpStr;

        return $this;
    }

    public function insert($src, $index)
    {
        $this->str = mb_substr($this->str, 0, $index, 'UTF-8').$src.mb_substr($this->str, $index, mb_strlen($this->str), 'UTF-8');

        return $this;
    }

    public function partition($sep)
    {
        if (mb_strpos($this->str, $sep) === false) {
            return array($this->str, '', '');
        }

        $startPosition = mb_strpos($this->str, $sep);
        $part1 = mb_substr($this->str, 0, $startPosition);

        $part2 = mb_substr($this->str, $startPosition+mb_strlen($sep), mb_strlen($this->str));

        return array($part1, $sep, $part2);
    }

    public function swapCase()
    {
        $output = '';
        for ($i = 0; $i < mb_strlen($this->str, 'UTF-8'); $i++) {
            $ch = mb_substr($this->str, $i, 1, 'UTF-8');
            if (mb_strtoupper($ch, 'UTF-8') == $ch) {
                $output .= mb_strtolower($ch, 'UTF-8');
            } else {
                $output .= mb_strtoupper($ch, 'UTF-8');
            }
        }
        $this->str = $output;

        return $this;
    }

    public function toSnakeCase()
    {
        // throw new \Exception("Not Implemented");
        // This function has some bugs. It pass the currect tests but for next iteration I'll have to think a better way to solve this and include the test witch it's not passing.
        $output = new XString('');
        $prev = null;
        $length = mb_strlen($this->str, 'UTF-8');
        for ($i = 0; $i < $length; $i++) {
            $ch = mb_substr($this->str, $i, 1, 'UTF-8');

            $isUpperCaseCh = mb_strtolower($ch, 'UTF-8') != $ch;
            if (!is_null($prev)) {

                $isUpperCasePrev =  mb_strtolower($prev, 'UTF-8') != $prev;

                $next = mb_substr($this->str, $i+1, 1, 'UTF-8');
                $isUpperCaseNext = false;
                if($next && $next!="_") { 
                    $isUpperCaseNext =  mb_strtolower($next, 'UTF-8') != $next;
                }

                if ($isUpperCasePrev && !$isUpperCaseCh && !$isUpperCaseNext && $next!="_" && $prev!="_" && $ch!="_") {
                    $output->insert('_', $i-1);
                } elseif ($isUpperCasePrev && !$isUpperCaseCh && $isUpperCaseNext && $ch!="_") {
                    $output->append(mb_strtolower($ch, 'UTF-8'));
                    $output->insert('_', $i+1);
                    $prev = $ch;
                    continue;
                } elseif (!$isUpperCasePrev && $isUpperCaseCh && !$isUpperCaseNext && $ch!="_" && $prev!="_") {
                    $output->append(mb_strtolower($ch, 'UTF-8'));
                    $output->insert('_', $i);
                    $prev = "_";
                    continue;
                }
            }
            
            $output->append(mb_strtolower($ch, 'UTF-8'));
            $prev = $ch;
        }

        $this->str = (string) $output;

        $this->str = str_replace(" ", "_", $this->str);

        return $this;
    }

    public function append($suffix)
    {
        $this->str .= $suffix;
    }

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

    public function scrub($repl)
    {
        $output = null;
        for ($i = 0; $i < mb_strlen($this->str, 'UTF-8'); $i++) {
            $ch = mb_substr($this->str, $i, 1, 'UTF-8');
            if (mb_check_encoding($ch, 'UTF-8')) {
                $output .= $ch;
            } else {
                $output .= $repl;
            }
        }

        return $output;
    }

    /** ExpandTabs can expand tabs ('\t') rune in str to one or more spaces dpending on
     / For example, CJK characters will be treated as two characters.
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
        for ($i = 0;$i<mb_strlen($this->str, 'UTF-8');$i++) {
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

    public static function numBytesOfRune($char)
    {
        return strlen(mb_substr($char, 0, 1, 'UTF-8'));
    }

    public function __toString()
    {
        return $this->str;
    }
}
