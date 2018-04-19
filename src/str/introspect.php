<?hh // strict
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */

namespace HH\Lib\Str;

use namespace HH\Lib\_Private;

/**
 * Returns < 0 if `$string1` is less than `$string2`, > 0 if `$string1` is
 * greater than `$string2`, and 0 if they are equal.
 *
 * For a case-insensitive comparison, see `Str\compare_ci()`.
 */
<<__Rx>>
function compare(
  string $string1,
  string $string2,
): int {
  return \strcmp($string1, $string2);
}

/**
 * Returns < 0 if `$string1` is less than `$string2`, > 0 if `$string1` is
 * greater than `$string2`, and 0 if they are equal (case-insensitive).
 *
 * For a case-sensitive comparison, see `Str\compare()`.
 */
<<__Rx>>
function compare_ci(
  string $string1,
  string $string2,
): int {
  return \strcasecmp($string1, $string2);
}

/**
 * Returns whether the "haystack" string contains the "needle" string.
 *
 * An optional offset determines where in the haystack the search begins. If the
 * offset is negative, the search will begin that many characters from the end
 * of the string. If the offset is out-of-bounds, a ViolationException will be
 * thrown.
 *
 * - To get the position of the needle, see `Str\search()`.
 * - To search for the needle case-insensitively, see `Str\contains_ci()`.
 */
<<__Rx>>
function contains(
  string $haystack,
  string $needle,
  int $offset = 0,
): bool {
  if ($needle === '') {
    _Private\validate_offset($offset, namespace\length($haystack));
    return true;
  }
  return namespace\search($haystack, $needle, $offset) !== null;
}

/**
 * Returns whether the "haystack" string contains the "needle" string
 * (case-insensitive).
 *
 * An optional offset determines where in the haystack the search begins. If the
 * offset is negative, the search will begin that many characters from the end
 * of the string. If the offset is out-of-bounds, a ViolationException will be
 * thrown.
 *
 * - To search for the needle case-sensitively, see `Str\contains()`.
 * - To get the position of the needle case-insensitively, see `Str\search_ci()`.
 */
<<__Rx>>
function contains_ci(
  string $haystack,
  string $needle,
  int $offset = 0,
): bool {
  if ($needle === '') {
    _Private\validate_offset($offset, namespace\length($haystack));
    return true;
  }
  return namespace\search_ci($haystack, $needle, $offset) !== null;
}

/**
 * Returns whether the string ends with the given suffix.
 *
 * For a case-insensitive check, see `Str\ends_with_ci()`.
 */
<<__Rx>>
function ends_with(
  string $string,
  string $suffix,
): bool {
  $suffix_length = namespace\length($suffix);
  return $suffix_length === 0 || (
    namespace\length($string) >= $suffix_length &&
    \substr_compare($string, $suffix, -$suffix_length, $suffix_length) === 0
  );
}

/**
 * Returns whether the string ends with the given suffix (case-insensitive).
 *
 * For a case-sensitive check, see `Str\ends_with()`.
 */
<<__Rx>>
function ends_with_ci(
  string $string,
  string $suffix,
): bool {
  $suffix_length = namespace\length($suffix);
  return $suffix_length === 0 || (
    namespace\length($string) >= $suffix_length &&
    \substr_compare(
      $string,
      $suffix,
      -$suffix_length,
      $suffix_length,
      true, // case-insensitive
    ) === 0
  );
}

/**
 * Returns whether the input is null or the empty string.
 */
<<__Rx>>
function is_empty(
  ?string $string,
): bool {
  return $string === null || $string === '';
}

/**
 * Returns the length of the given string, i.e. the number of bytes.
 */
<<__Rx>>
function length(
  string $string,
): int {
  return \strlen($string);
}

/**
 * Returns the first position of the "needle" string in the "haystack" string,
 * or null if it isn't found.
 *
 * An optional offset determines where in the haystack the search begins. If the
 * offset is negative, the search will begin that many characters from the end
 * of the string. If the offset is out-of-bounds, a ViolationException will be
 * thrown.
 *
 * - To simply check if the haystack contains the needle, see `Str\contains()`.
 * - To get the case-insensitive position, see `Str\search_ci()`.
 * - To get the last position of the needle, see `Str\search_last()`.
 *
 * Previously known in PHP as `strpos`.
 */
<<__Rx>>
function search(
  string $haystack,
  string $needle,
  int $offset = 0,
): ?int {
  $offset = _Private\validate_offset($offset, namespace\length($haystack));
  $position = \strpos($haystack, $needle, $offset);
  if ($position === false) {
    return null;
  }
  return $position;
}

/**
 * Returns the first position of the "needle" string in the "haystack" string,
 * or null if it isn't found (case-insensitive).
 *
 * An optional offset determines where in the haystack the search begins. If the
 * offset is negative, the search will begin that many characters from the end
 * of the string. If the offset is out-of-bounds, a ViolationException will be
 * thrown.
 *
 * - To simply check if the haystack contains the needle, see `Str\contains()`.
 * - To get the case-sensitive position, see `Str\search()`.
 * - To get the last position of the needle, see `Str\search_last()`.
 *
 * Previously known in PHP as `stripos`.
 */
<<__Rx>>
function search_ci(
  string $haystack,
  string $needle,
  int $offset = 0,
): ?int {
  $offset = _Private\validate_offset($offset, namespace\length($haystack));
  $position = \stripos($haystack, $needle, $offset);
  if ($position === false) {
    return null;
  }
  return $position;
}

/**
 * Returns the last position of the "needle" string in the "haystack" string,
 * or null if it isn't found.
 *
 * An optional offset determines where in the haystack (from the beginning) the
 * search begins. If the offset is negative, the search will begin that many
 * characters from the end of the string and go backwards. If the offset is
 * out-of-bounds, a ViolationException will be thrown.
 *
 * - To simply check if the haystack contains the needle, see `Str\contains()`.
 * - To get the first position of the needle, see `Str\search()`.
 *
 * Previously known in PHP as `strrpos`.
 */
<<__Rx>>
function search_last(
  string $haystack,
  string $needle,
  int $offset = 0,
): ?int {
  $haystack_length = namespace\length($haystack);
  invariant(
    $offset >= -$haystack_length && $offset <= $haystack_length,
    'Offset is out-of-bounds.',
  );
  $position = \strrpos($haystack, $needle, $offset);
  if ($position === false) {
    return null;
  }
  return $position;
}

/**
 * Returns whether the string starts with the given prefix.
 *
 * For a case-insensitive check, see `Str\starts_with_ci()`.
 */
<<__Rx>>
function starts_with(
  string $string,
  string $prefix,
): bool {
  return \strncmp($string, $prefix, namespace\length($prefix)) === 0;
}

/**
 * Returns whether the string starts with the given prefix (case-insensitive).
 *
 * For a case-sensitive check, see `Str\starts_with()`.
 */
<<__Rx>>
function starts_with_ci(
  string $string,
  string $prefix,
): bool {
  return \strncasecmp($string, $prefix, namespace\length($prefix)) === 0;
}
