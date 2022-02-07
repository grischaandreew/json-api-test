<?php
namespace Base;

class Unit extends \Codeception\Test\Unit {
  
  use \Codeception\Specify;
  
  /**
   * @var \UnitTester
   */
  protected $tester;
  
  protected function _before()
  {
    $this->tester = new Laravel( );
    $this->tester->setLaravelModule( $this->getModule("Laravel5") );
    $this->tester->setUp();
    parent::_before();
  }

  protected function _after()
  {
    $this->tester->tearDown();
    parent::_after();
    $this->getModule("Laravel5")->clearApplicationHandlers();
  }
  
  /**
   * reset application and create new
   * this is needed when the testcase has many ->describe and ->it functions and the application state has to be reset
   */
  protected function refresh(){
    $this->_after();
    $this->getModule("Laravel5")->_after($this);
    $this->getModule("Laravel5")->_before($this);
    $this->_before();
  }
}
