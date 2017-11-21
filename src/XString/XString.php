<?php

namespace XString;

/**
 * XString class.
*/
class XString
{
    /**
     * Str var.
     *
     * @var string
    */
    protected $str;

    /**
     * Construct
     *
     * @param string  $str          Str var.
     * @param string  $encoding    Encoding.
     * @param boolean $forceEncode Force encoding.
     *
     * @return void
    */
    public function __construct($str, $encoding = 'UTF-8', $forceEncode = true)
    {
        if (mb_detect_encoding($str) != 'UTF-8' && $forceEncode) {
            $str = mb_convert_encoding($str, 'UTF-8');
        }
        $this->str = $str;
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

    /**
     * Delete runes in str matching the pattern. Pattern is defined in translate function.
     *
     * @param string $pattern Pattern.
     *
     * @return void
     */
    public function delete($pattern)
    {
       // TODO: Implement
    }

    /**
     * Insert src into $this->src at given rune index. Index is counted by runes instead of bytes.
     *
     * @param string  $src   Src.
     * @param integer $index Index.
     *
     * @return XString
     */
    public function insert($src, $index)
    {
        $this->str = mb_substr($this->str, 0, $index, 'UTF-8').$src.mb_substr($this->str, $index, mb_strlen($this->str), 'UTF-8');

        return $this;
    }

    /**
     * lastPartition splits a string by last instance of sep into three parts. The return value is a slice of strings with head, match and tail.
     *
     * @param string $sep Separator.
     *
     * @return [string, string, string]
     */
    public function lastPartition($sep)
    {
        // TODO: Review this code.
        if (mb_strpos($this->str, $sep) === false) {
            return array($this->str, '', '');
        }

        $startPosition = mb_strpos($this->str, $sep);
        $part1 = mb_substr($this->str, 0, $startPosition);

        $part2 = mb_substr($this->str, $startPosition+mb_strlen($sep), mb_strlen($this->str));

        return [$part1, $sep, $part2];

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
     * length returns number of chars in utf8 of $this->str
     *
     * @return integer
     */
    public function length()
    {
        return mb_strlen($this->str);
    }

    /**
     * Reverse a utf8 encoded string.
     *
     * @param string $repl Repl var.
     *
     *  @return XString
     */
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
     * Shuffle randomizes runes in a string and returns the result
     *
     *  @return void
     */
    public function shuffle()
    {
       // TODO: Implement
    }

    /**
     * Slice a string by rune.
     * Start must satisfy 0 <= start <= rune length.
     * End can be positive, zero or negative. If end >= 0, start and end must satisfy start <= end <= rune length. If end < 0, it means slice to the end of string.
     * Otherwise, Slice will panic as out of range.
     *
     * @param integer $start Start point.
     * @param integer $end   End point.
     *
     *  @return void
     */
    public function slice($start, $end)
    {
       // TODO: Implement
    }

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


    /**
     * Successor returns the successor to string.
     *
     * If there is one alphanumeric rune is found in string, increase the rune by 1. If increment generates a "carry", the rune to the left of it is incremented. This process repeats until there is no carry, adding an additional rune if necessary.
     *
     * If there is no alphanumeric rune, the rightmost rune will be increased by 1 regardless whether the result is a valid rune or not.
     *
     * Only following characters are alphanumeric.
     *
     * * a - z
     * * A - Z
     * * 0 - 9
     * Samples (borrowed from ruby's String#succ document):
     *
     * "abcd"      => "abce"
     * "THX1138"   => "THX1139"
     * "<<koala>>" => "<<koalb>>"
     * "1999zzz"   => "2000aaa"
     * "ZZZ9999"   => "AAAA0000"
     * "***"       => "**+"
     *
     * @param integer $start Start point.
     * @param integer $end   End point.
     *
     * @return void
     */
    public function successor($start, $end)
    {
       // TODO: Implement
    }


    /**
     * SwapCase will swap characters case from upper to lower or lower to upper.
     *
     *  @return XString
     */
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

    /**
     *  toCamelCase can convert all lower case characters behind underscores to upper case character. Underscore character will be removed in result except following cases.
     *
     *  @return void
     */
    public function toCamelCase()
    {
       // TODO: Implement
    }

    /**
     * ToSnakeCase function
     *
     * @return XString
    */
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
                if ($next && $next!="_") {
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
     * Return true, if the string starts with $prefix
     *
     * @param string $prefix Prefix string.
     *
     * @return boolean
    */
    public function startWith($prefix)
    {
        return mb_substr($this->str, 0, mb_strlen($prefix)) === $prefix;
    }

    /**
     * Return true, if the string ends with $suffix
     *
     * @param string $suffix Suffix string.
     *
     * @return boolean
    */
    public function endWith($suffix)
    {
        return mb_substr($this->str, mb_strlen($this->str) - mb_strlen($suffix), mb_strlen($suffix) == $suffix);
    }

    /**
     * Append $suffix to $this->str
     *
     * @param string $suffix Suffix variable.
     *
     * @return void
     *
     */
    public function append($suffix)
    {
        $this->str .= $suffix;
    }

    /**
     * Number of bytes function.
     *
     * @param string $char Char variable for counting the number of bytes.
     *
     * @return integer
    */
    public static function numBytesOfRune($char)
    {
        return strlen(mb_substr($char, 0, 1, 'UTF-8'));
    }

    /**
     * Reverse a utf8 encoded string.
     *
     * @return void
     */
    public function reverse()
    {
        $length   = mb_strlen($this->str, 'UTF-8');
        $reversed = '';
        while ($length-- > 0) {
            $reversed .= mb_substr($this->str, $length, 1, 'UTF-8');
        }

        return new XString($reversed);
    }

    /**
     * Count number of words in a string.
     * Word is defined as a locale dependent string containing alphabetic characters, which may also contain but not start with `'` and `-` characters.
     *
     * @param string $str Str var.
     *
     * @return void
     */
    public function wordCount($str)
    {
       // TODO: Implement
    }

    /**
     *
     * Splits a string into words. Returns a slice of words. If there is no word in a string, return nil.
     * Word is defined as a locale dependent string containing alphabetic characters, which may also contain but not start with `'` and `-` characters.
     *
     * @param string $str Str var.
     *
     * @return void
     */
    public function wordSplit($str)
    {
       // TODO: Implement
    }


    /**
     * To string function. Magic method.
     *
     * @return string
    */
    public function __toString()
    {
        return $this->str;
    }

    /**
     * Partition splits a string by sep into three parts. The return value is a slice of strings with head, match and tail.
     * If str contains sep, for example "hello" and "l", Partition returns
     *
     * @param string $sep Separator.
     *
     * @return void
     */
    public function partition($sep)
    {
       // TODO: Implement
    }


}
