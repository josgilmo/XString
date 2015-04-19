<?php

//TODO: Refactor with the use and the bootstrap.php for testing, and the phpunit.xml file

use XString\XString;

class XStringTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->xstring = new XString('hello world');
    }

    public function tearDown()
    {
        unset($this->xstring);
    }

    public function testCenter()
    {
        $this->assertEquals(' hello world ', $this->xstring->center(1));
    }

    public function testStartWith() {
        $xstring = new XString("hello world");
        $this->assertTrue($xstring->startWith("hello"));

        $this->assertFalse($xstring->startWith("world"));
    }

    /**
     * @dataProvider swapCaseProvider
    */
    public function testSwapCase($str, $expected) {
        $xstring = new XString($str);
        $this->assertEquals($expected, $xstring->swapCase());
    }

    public function swapCaseProvider() {
        return Array(
            Array("swapCase", "SWAPcASE"),
            Array("Θ~λa云Ξπ",  "θ~ΛA云ξΠ"),
        );
    }

    /**
     * @dataProvider toSnakeCaseProvider
    */ 
    public function testToSnakeCase($str, $expected){
//        $this->markTestSkipped("Not implemented yet!");

        $xstring = new XString($str);
        $this->assertEquals($expected, $xstring->toSnakeCase());
    } 

    public function toSnakeCaseProvider() {
        return Array(
           Array("HTTPServer", "http_server"),
           Array( "NoHTTPS", "no_https"),
           Array( "Wi_thF",    "wi_th_f"),
           Array( "ALL",                "all"),
           Array( "_camelCase", "_camel_case"),
           Array( "HELLO_WORLD",        "hello_world"),
           Array( "_HELLO_WORLD_",      "_hello_world_"),
           Array( "TW",                 "tw"),
           Array("_C",                 "_c"),
           Array( "HELLO____WORLD",     "hello____world"),
           Array("  sentence case  ",                                    "__sentence_case__"),
           // Test not passed yet
           // "_AnotherTES_TCaseP": "_another_tes_t_case_p",
           // " Mixed-hyphen case _and SENTENCE_case and UPPER-case": "_mixed_hyphen_case__and_sentence_case_and_upper_case",
        );
    }


    public function testExpandTab()
    {
        $xstring = new XString("a\tbc\tdef\tghij\tk");
        $this->assertEquals('a   bc  def ghij    k', $xstring->expandTabs(4));

        $xstring = new XString("abcdefg\thij\nk\tl");
        $this->assertEquals("abcdefg hij\nk   l", $xstring->expandTabs(4));

        /*
        $xstring = new XString("z中\t文\tw");
        $this->assertEquals("z中 文  w", $xstring->expandTabs(4));
        */
    }

    /**
     * @dataProvider insertProvider
     */
    public function testInsert($str, $src, $index, $expected)
    {
        $nxs = new XString($str);
        $this->assertEquals($expected, $nxs->insert($src, $index));
    }

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
     */
    public function testPartition($str, $sep, $part1, $part2)
    {
        $nxs = new XString($str);
        $arr = $nxs->partition($sep);
        $this->assertEquals($arr[0], $part1);
        $this->assertEquals($arr[1], $sep);
        $this->assertEquals($arr[2], $part2);
    }

    public function partitionProvider() {
        return Array(
            Array("hello", "l", "he", "lo"),
            Array("z这个zh英文混排hao不", "h英文", "z这个z", "混排hao不"),
        );
    }

    /**
     * @dataProvider scrubProvider
    */
    public function testScrub($str, $sepr, $expected) {
        $this->markTestSkipped("Not implemented yet!");
        $nxs = new XString($str, 'UTF-8', false);
        $this->assertEquals($expected, $nxs->scrub($sepr));
    }

    public function scrubProvider() {
        return Array(
            Array("ab\uFFFDcd\xFF\xCEefg\xFF\xFC\xFD\xFAhijk", "*", "ab*cd*efg*hijk"),
 //           Array("no错误です", "*",                                    "no错误です"),
        );
    }

    /**
     *  @dataProvider squeezeProvider
     */
    public function testSqueeze($str, $pattern, $expected) { 
        $nxs = new XString($str, 'UTF-8');
        $this->assertEquals($expected, $nxs->squeeze($pattern));
    }

    public function squeezeProvider() {
        return Array(
            Array("hello", "",     "helo"),
            Array("hello", "a-k",  "hello"),
            Array("hello", "a-m",  "helo"),
            Array("hello", "^a-k", "helo"),
            Array("hello", "^a-l", "hello"),
            Array("打打打打个劫！！", "",  "打个劫！"),
            Array("打打打打打打个劫！！", "打", "打个劫！！"),
        );
    }

    /**
     * @dataProvider rightJustifyProvider
    */
    public function testRightJustify($str, $size, $content, $expected) {
        $nxs = new XString($str);
        $this->assertEquals($expected, $nxs->rightJustify($size, $content));
    }

    public function rightJustifyProvider() {
        return Array(
            Array("hello", 10, " ", "     hello"),
            Array("hello", 10, "123", "12312hello"),
        );
    }

    public function testNumBytesOfRune()
    {
        $this->assertEquals(3, XString::numBytesOfRune('文'));

        $this->assertEquals(3, XString::numBytesOfRune('中'));
    }
}
