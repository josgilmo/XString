<?php

namespace XString;

trait Manipulate
{

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
}
