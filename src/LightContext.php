<?php

class LightContext extends ArrayObject {

  public static function build($params) {
    return (is_object($params) && get_class($params) == 'LightContext') ? $params : new LightContext($params);
  }

  private $halted;
  private $failure;
  private $failureMessage;

  public function __construct(array $params) {
    parent::__construct($params, self::ARRAY_AS_PROPS);

    $this->halted = false;
    $this->failure = false;
  }

  public function success() {
    return !($this->failure);
  }

  public function failure() {
    return $this->failure;
  }

  public function halted() {
    return $this->halted;
  }

  public function halt() {
    $this->halt = true;
  }

  public function fail($msg = null) {
    $this->failureMessage = $msg;
    $this->failure = true;
  }
}