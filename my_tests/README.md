Any PHP files present in this directory will NOT be added to source control, but will
be considered to constitute a separate, temporary unit test suite. This can be used to
develop new tests more rapidly in isolation, or to isolate failing tests for easier
debugging.

Each file must contain one or more test case classes, each instances of or
subclassing UnitTestCase.

The file "example.php" is included to provide an example, but feel free to delete it.

To run this test suite, append `?dir=tests` to the test case URL. E.g.:

    http://localhost/elgg/engine/tests/suite.php?dir=my_tests

