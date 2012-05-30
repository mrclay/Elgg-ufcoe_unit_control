<?php

class UnitControlExampleTest extends UnitTestCase {

	public function testExample() {
		$this->_reporter->paintHeader('testExample in my_tests');
		$this->assertTrue(true, 'Testing 123');
	}
}
