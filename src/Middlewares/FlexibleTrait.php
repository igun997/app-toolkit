<?php
namespace igun997\Middlewares;
/***
 * Trait FlexibleTrait
 * @package igun997\Middlewares
 */
trait FlexibleTrait {
    public $storage;

    /***
     * @param $function = function()
     * @param $callback = mixed result
     */
    public function operation($function,&$callback):void
    {
        $callback = $function($this->storage);
    }
}