<?hh // strict
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */

use namespace HH\Lib\Dict;
use function Facebook\FBExpect\expect;
use type Facebook\HackTest\HackTestCase;

/**
 * @emails oncall+hack
 */
final class DictCombineTest extends HackTestCase {

  public static function provideTestAssociate(): vec<mixed> {
    return vec[
      tuple(
        vec[3, 2, 1],
        Vector {'a', 'b', 'c'},
        dict[
          3 => 'a',
          2 => 'b',
          1 => 'c',
        ],
      ),
      tuple(
        range(0, 3),
        HackLibTestTraversables::getIterator(range(0, 3)),
        dict[
          0 => 0,
          1 => 1,
          2 => 2,
          3 => 3,
        ],
      ),
      tuple(
        Map {
          1 => 2,
          2 => 4,
        },
        dict[
          3 => 6,
          4 => 8,
        ],
        dict[
          2 => 6,
          4 => 8,
        ],
      ),
    ];
  }

  /** @dataProvider provideTestAssociate */
  public function testAssociate<Tk as arraykey, Tv>(
    Traversable<Tk> $keys,
    Traversable<Tv> $values,
    dict<Tk, Tv> $expected,
  ): void {
    expect(Dict\associate($keys, $values))->toBeSame($expected);
  }

  public static function provideTestMerge(): vec<mixed> {
    return vec[
      tuple(
        Map {},
        darray[],
        dict[],
      ),
      tuple(
        darray[
          'one' => 'one',
          'two' => 'two',
        ],
        vec[
          darray[
            'three' => 'three',
            'one' => 3,
          ],
          Map {
            'four' => null,
          },
        ],
        dict[
          'one' => 3,
          'two' => 'two',
          'three' => 'three',
          'four' => null,
        ],
      ),
      tuple(
        HackLibTestTraversables::getKeyedIterator(darray[
          'foo' => 'foo',
          'bar' => 'bar',
          'baz' => vec[1, 2, 3],
        ]),
        vec[
          dict[
            'bar' => 'barbar',
          ],
          Vector {'I should feel bad for doing this', 'But yolo'},
          darray[
            '1' => 'gross array behavior',
          ],
          Set {'bloop'},
        ],
        dict[
          'foo' => 'foo',
          'bar' => 'barbar',
          'baz' => vec[1, 2, 3],
          0 => 'I should feel bad for doing this',
          1 => 'gross array behavior',
          'bloop' => 'bloop',
        ],
      ),
    ];
  }

  /** @dataProvider provideTestMerge */
  public function testMerge<Tk as arraykey, Tv>(
    KeyedTraversable<Tk, Tv> $first,
    Container<KeyedTraversable<Tk, Tv>> $rest,
    dict<Tk, Tv> $expected,
  ): void {
    expect(Dict\merge($first, ...$rest))->toBeSame($expected);
  }
}
