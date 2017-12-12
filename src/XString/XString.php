<?php

namespace XString;

/**
 * XString class.
*/
class XString implements \ArrayAccess
{
    use Format;
    use Manipulate;
    use Convert;
    use Translate;

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
     * length returns number of chars in utf8 of $this->str
     *
     * @return integer
     */
    public function length()
    {
        return mb_strlen($this->str);
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
     * To string function. Magic method.
     *
     * @return string
    */
    public function __toString()
    {
        return $this->str;
    }


    /**
         * Get a specific chars of the current string.
         *
         * @param   int     $offset    Offset (can be negative and unbound).
         * @return  string
         */
    public function offsetGet($offset)
    {
        return mb_substr($this->string, $this->computeOffset($offset), 1);
    }
    /**
     * Set a specific character of the current string.
     *
     * @param   int     $offset    Offset (can be negative and unbound).
     * @param   string  $value     Value.
     * @return  \Hoa\Ustring
     */
    public function offsetSet($offset, $value)
    {
        $head   = null;
        $offset = $this->computeOffset($offset);
        if (0 < $offset) {
            $head = mb_substr($this->str, 0, $offset);
        }
        $tail             = mb_substr($this->str, $offset + 1);
        $this->str    = $head . $value . $tail;

        return $this;
    }

    /**
     * Delete a specific character of the current string.
     *
     * @param   int     $offset    Offset (can be negative and unbound).
     * @return  string
     */
    public function offsetUnset($offset)
    {
        return $this->offsetSet($offset, null);
    }
    /**
     * Check if a specific offset exists.
     *
     * @return  bool
     */
    public function offsetExists($offset)
    {
        return true;
    }


    /**
     * Compute offset (negative, unbound etc.).
     *
     * @param   int        $offset    Offset.
     * @return  int
     */
    protected function computeOffset($offset)
    {
        $length = mb_strlen($this->str);
        if (0 > $offset) {
            $offset = -$offset % $length;
            if (0 !== $offset) {
                $offset = $length - $offset;
            }
        } elseif ($offset >= $length) {
            $offset %= $length;
        }
        return $offset;
    }
}
