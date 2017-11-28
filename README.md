
# XStrings

[![Build Status](https://travis-ci.org/josgilmo/XString.png?branch=master)](https://travis-ci.org/josgilmo/XString)
[![Coverage Status](https://coveralls.io/repos/github/josgilmo/XString/badge.svg?branch=develop)](https://coveralls.io/github/josgilmo/XString?branch=develop)

XString it's a port in PHP of the Go library [XStrings](https://github.com/huandu/xstrings). It was started as a documetation for my book about testing in PHP (in Spanish) but my intention it's to keep working on this repository and enrich the strings manipulation in PHP.

In the beginning of this package we are not using the semver nomenclature, so not use it in your proyect for now.

Pull request and ideas are welcome.


| Function | Friends | # |
| -------- | ------- | --- |
| [Center] | `str.center` in Python; `String#center` in Ruby |  |
| [Insert] | `String#insert` in Ruby |  |
| [SwapCase] | `str.swapcase` in Python; `String#swapcase` in Ruby | |
| [ToSnakeCase] | `String#underscore` in RoR | |
| [ExpandTabs] | `str.expandtabs` in Python |  |
| [LastPartition] | `str.rpartition` in Python; `String#rpartition` in Ruby |  |
| [Scrub] | `String#scrub` in Ruby |  |
| [RightJustify] | `str.rjust` in Python; `String#rjust` in Ruby |  |
| [Squeeze] | `String#squeeze` in Ruby | |
| [Count] | `String#count` in Ruby |  |
| [Delete] | `String#delete` in Ruby |  |
| [startWith] |  |  |
| [Reverse] | `String#reverse` in Ruby; `strrev` in PHP; `reverse` in Perl |  |


@todo:

| Function | Friends | # |
| -------- | ------- | --- |
| [LeftJustify] | `str.ljust` in Python; `String#ljust` in Ruby | [1](https://github.com/josgilmo/XString/issues/1) |
| [Partition] | `str.partition` in Python; `String#partition` in Ruby | [2](https://github.com/josgilmo/XString/issues/2) |
| [Successor] | `String#succ` or `String#next` in Ruby | [3](https://github.com/josgilmo/XString/issues/3) |
| [ToCamelCase] | `String#camelize` in RoR | [4](https://github.com/josgilmo/XString/issues/3) |
| [Translate] | `str.translate` in Python; `String#tr` in Ruby; `strtr` in PHP; `tr///` in Perl | |
| [RuneWidth] | - |  |
| [ShuffleSource] | `str_shuffle` in PHP |  |


| Function | Friends | # |
| -------- | ------- | --- |
| [WordSplit] | - | |
| [Width] | `mb_strwidth` in PHP | |
| [WordCount] | `str_word_count` in PHP | |
| [Slice] | `mb_substr` in PHP | |
| [Shuffle] | `str_shuffle` in PHP |  |
| [Len] | `mb_strlen` in PHP |  |
| [FirstRuneToLower] | `lcfirst` in PHP or Perl |  |
| [FirstRuneToUpper] | `String#capitalize` in Ruby; `ucfirst` in PHP or Perl |  |
