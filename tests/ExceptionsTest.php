<?php

include './lib/Exceptions.php';

class ExceptionsTest extends PHPUnit_Framework_TestCase {

  public function testUndefinedAction() {
    $this->setExpectedException('UndefinedActionException', 'Action is undefined');
    throw new UndefinedActionException();
  }

  public function testExceptionHasRightMessage() {
    $this->setExpectedException('UndefinedActionException', 'Failed');
    throw new UndefinedActionException('Failed', 10);
  }

  public function testExceptionHasRightCode() {
    $this->setExpectedException('UndefinedActionException', 'Action is undefined', 20);
    throw new UndefinedActionException('Action is undefined', 20);
  }
}

?>
