<?php

namespace XString;

trait Convert {

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

}
