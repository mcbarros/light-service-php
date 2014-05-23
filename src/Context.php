<?php
namespace LightServicePHP;

class Context extends \ArrayObject {

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

  public function getFailureMessage() {
    return $this->failureMessage;
  }

  public function hasKeys(array $keys) {
    $has = true;

    foreach ($keys as $key) {
      $has &= $this->offsetExists($key);
    }

    return $has;
  }
}