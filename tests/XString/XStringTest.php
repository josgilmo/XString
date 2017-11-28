<?php

namespace Test;

use XString\XString;

/**
 * XStringTest Class.
 */
class XStringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * setUp method
     *
     * @return void
    */
    public function setUp()
    {
        $this->xstring = new XString('hello world');
    }

    /**
     * terDown method
     *
     * @return void
    */
    public function tearDown()
    {
        unset($this->xstring);
    }

    /**
     * Test for center method.
     *
     * @return void
    */
    public function testCenter()
    {
        $this->assertEquals(' hello world ', $this->xstring->center(1));
    }

    /**
     * Test for startWith method.
     *
     * @return void
    */
    public function testStartWith()
    {
        $xstring = new XString('hello world');
        $this->assertTrue($xstring->startWith('hello'));

        $this->assertFalse($xstring->startWith('world'));
    }

    /**
     * @dataProvider swapCaseProvider
     *
     * @param string $str      String to swap.
     * @param string $expected Expected result.
     *
     *
     * @return void
     */
    public function testSwapCase($str, $expected)
    {
        $xstring = new XString($str);
        $this->assertEquals($expected, $xstring->swapCase());
    }

    /**
     * Test for swapCase method.
     *
     * @return [[string, string]]
    */
    public function swapCaseProvider()
    {
        return array(
            array('swapCase', 'SWAPcASE'),
            array('Θ~λa云Ξπ',  'θ~ΛA云ξΠ'),
        );
    }

    /**
     * @dataProvider toSnakeCaseProvider
     *
     * @param string $str      String to be changed to snake.
     * @param string $expected Expected result.
     *
     *
     * @return void
     */
    public function testToSnakeCase($str, $expected)
    {
        //        $this->markTestSkipped("Not implemented yet!");

        $xstring = new XString($str);
        $this->assertEquals($expected, $xstring->toSnakeCase());
    }

    /**
     * Test for toSnakeCase method.
     *
     * @return [[string, string]]
    */
    public function toSnakeCaseProvider()
    {
        return array(
           array('HTTPServer', 'http_server'),
           array('NoHTTPS', 'no_https'),
           array('Wi_thF',    'wi_th_f'),
           array('ALL',                'all'),
           array('_camelCase', '_camel_case'),
           array('HELLO_WORLD',        'hello_world'),
           array('_HELLO_WORLD_',      '_hello_world_'),
           array('TW',                 'tw'),
           array('_C',                 '_c'),
           array('HELLO____WORLD',     'hello____world'),
           array('  sentence case  ',                                    '__sentence_case__'),
           // Test not passed yet
           // "_AnotherTES_TCaseP": "_another_tes_t_case_p",
           // " Mixed-hyphen case _and SENTENCE_case and UPPER-case": "_mixed_hyphen_case__and_sentence_case_and_upper_case",
        );
    }

    /**
     * Test for expandTab method.
     *
     * @dataProvider expandTabProvider
     * @return void
    */
    public function testExpandTab($input, $i, $expected)
    {
        $xstring = new XString($input);
        $this->assertEquals($expected, (string)$xstring->expandTabs($i));

    }


    public function expandTabProvider() 
    {  
        return array(
            array("a\tbc\tdef\tghij\tk", 4, "a   bc  def ghij    k"),
            array("abcdefg\thij\nk\tl", 4, "abcdefg hij\nk   l"),
            array("z中\t文\tw", 4, "z中 文  w"),
            array("abcdef", 4, "abcdef"),
            array("abc\td\tef\tghij\nk\tl", 3, "abc   d  ef ghij\nk  l"),
            array("abc\td\tef\tghij\nk\tl", 1, "abc d ef ghij\nk l"),

        );
    }

    public function testExpandTabThrowException() {
        $this->expectException(\Exception::class);
        $xstring = new XString("test");
        $xstring->expandTabs(0);
    }

    public function testExpandTabWithNegativeValueThrowException() {
        $this->expectException(\Exception::class);
        $xstring = new XString("test");
        $xstring->expandTabs(-1);
    }

    /**
     * @dataProvider insertProvider
     *
     * @param string  $str      String to be tested.
     * @param string  $src      Src.
     * @param integer $index    Index for be inserted.
     * @param string  $expected Expected result.
     *
     * @return void
     */
    public function testInsert($str, $src, $index, $expected)
    {
        $nxs = new XString($str);
        $this->assertEquals($expected, $nxs->insert($src, $index));
    }

    /**
     * Test for insert method
     *
     * @return [[string, string, integer, string]]
     */
    public function insertProvider()
    {
        return array(
            array('abcdefg', 'hi', 3, 'abchidefg'),
            array('插在ending', '我', '8', '插在ending我'),
            array('少量中文是必须的', '混pai', '4', '少量中文混pai是必须的'),
        );
    }

    /**
     * @dataProvider partitionProvider
     *
     * @param string $str   String for test.
     * @param string $array   Separator.
     * @param string $part1 Part one of result.
     * @param string $part2 Part two of result.
     *
     * @return void
     */
    public function testLastPartition($str, $array, $part1, $part2)
    {
        $nxs = new XString($str);
        $arr = $nxs->lastPartition($array);
        $this->assertEquals($arr[0], $part1);
        $this->assertEquals($arr[1], $array);
        $this->assertEquals($arr[2], $part2);
    }

    /**
     * dataProvider for partition test
     *
     * @return [[string, string, string, string]]
     */
    public function partitionProvider()
    {
        return array(
            array('hello', 'l', 'he', 'lo'),
            array('z这个zh英文混排hao不', 'h英文', 'z这个z', '混排hao不'),
        );
    }

    /**
     * @dataProvider scrubProvider
     * @param string $str      String to be tested.
     * @param string $arrayr     Separator.
     * @param string $expected Expected result.
     *
     * @return void
     */
    public function testScrub($str, $arrayr, $expected)
    {
        $this->markTestSkipped('Not implemented yet!');
        $nxs = new XString($str, 'UTF-8', false);
        $this->assertEquals($expected, $nxs->scrub($arrayr));
    }

    /**
     *  data provider for scrub test
     *
     * @return [[string, string, string]]
     */
    public function scrubProvider()
    {
        return array(
            array("ab\uFFFDcd\xFF\xCEefg\xFF\xFC\xFD\xFAhijk", '*', 'ab*cd*efg*hijk'),
 //           Array("no错误です", "*",                                    "no错误です"),
        );
    }

    /**
     * @dataProvider squeezeProvider
     * @param string $str      String to be tested.
     * @param string $pattern  Pattern.
     * @param string $expected Expected result.
     *
     * @return void
     */
    public function testSqueeze($str, $pattern, $expected)
    {
        $nxs = new XString($str, 'UTF-8');
        $this->assertEquals($expected, $nxs->squeeze($pattern));
    }

    /**
     * Data provider for squeeze test
     *
     * @return [[string, string, string]]
    */
    public function squeezeProvider()
    {
        return array(
            array('hello', '',     'helo'),
            array('hello', 'a-k',  'hello'),
            array('hello', 'a-m',  'helo'),
            array('hello', '^a-k', 'helo'),
            array('hello', '^a-l', 'hello'),
            array('打打打打个劫！！', '',  '打个劫！'),
            array('打打打打打打个劫！！', '打', '打个劫！！'),
        );
    }

    /**
     * @dataProvider rightJustifyProvider
     * @param string  $str      String to be tested.
     * @param integer $size     Size.
     * @param string  $content  String for fill the justification.
     * @param string  $expected Expected result.
     *
     * @return void
     */
    public function testRightJustify($str, $size, $content, $expected)
    {
        $nxs = new XString($str);
        $this->assertEquals($expected, $nxs->rightJustify($size, $content));
    }

    /**
     * @dataProvider rightJustifyProvider
     *
     * @return [[string, int, string, string]]
     */
    public function rightJustifyProvider()
    {
        return array(
            array('hello', 10, ' ', '     hello'),
            array('hello', 10, '123', '12312hello'),
            array("hello", "10", "123", "12312hello"),
            array("hello中文test", "4", " ",    "hello中文test"),
            array("hello中文test", "12", " ",   " hello中文test"),
            array("hello中文test", "18", "测试！", "测试！测试！测hello中文test"),
            array("hello中文test", "0", "123", "hello中文test"),
/*
*/
            array("hello中文test", "18", "",   "hello中文test"),
        );
    }

    /**
     * Test Number of bytes
     *
     * @return void
    */
    public function testNumBytesOfRune()
    {
        $this->assertEquals(3, XString::numBytesOfRune('文'));

        $this->assertEquals(3, XString::numBytesOfRune('中'));
    }

    public function testReverse()
    {
        $hello = new XString("hello");
        $this->assertEquals("olleh", (string)$hello->reverse());
        $text2 = new XString("打个劫");
        $this->assertEquals("劫个打", (string)$text2->reverse());
    }
}
