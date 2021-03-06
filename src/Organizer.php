<?php
namespace LightServicePHP;

abstract class Organizer extends Action {

    protected $organize;
    protected $performed = array();

    protected function __construct($params) {
        parent::__construct($params);

        if (empty($this->organize)) {
            $this->fail('Specify the actions to be executed by this organizer');
        }
    }

    protected function perform() {
        foreach ($this->organize as $action) {
            $instance = $action::execute($this->context);

            if ($this->failure()) {
                $this->rollback();
                break;
            }

            $this->performed[] = $instance;

            if ($this->halted()) {
                break;
            }
        }
    }

    protected function rollback() {
        $index = count($this->performed);

        while($index) {
            $this->performed[--$index]->rollback();
        }
    }

    protected function caught(\Exception $ex) {
        $this->rollback();
        throw $ex;
    }
}
