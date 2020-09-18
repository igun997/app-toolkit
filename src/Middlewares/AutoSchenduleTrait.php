<?php
namespace Igun997\Toolkit\Middlewares;
/***
 * Trait AutoSchenduleTrait
 * @package igun997\Middlewares
 */
trait AutoSchenduleTrait {
    protected $rawData;
    protected $onprogressData;
    protected $finalizeData;

    /***
     * @param $variable [possible var :  rawData onprogressData finalizeData]
     * @return bool
     */
    protected function cleanData($variable):bool
    {
        if (isset($this->$variable)){
            $this->$variable = null;
            return true;
        }
        return false;
    }
}