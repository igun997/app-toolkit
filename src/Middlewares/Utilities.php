<?php

namespace igun997\Middlewares;

use Rakit\Validation\Validator;

/***
 * Trait Utilities
 * @package igun997\Middlewares
 */
trait Utilities {
    protected $_err_data;
    protected $_success_data;
    protected $_exception_data;

    /**
     * @param array $data
     * @param array $rules
     * @return bool
     */
    protected function validator(array $data,array $rules):bool
    {
        $valid = new Validator;
        $trans = $valid->make($data,$rules);
        $trans->validate();

        if ($trans->fails()){
            $this->_exception_data = $trans->errors();
            $this->_err_data = $this->_exception_data->toArray();
        }else{
            $this->_success_data = $data;
        }
        return $trans->fails();
    }

    /***
     * @return array
     */
    protected function getError()
    {
        if (empty($this->_err_data)){
            $this->_err_data = [];
        }
        return $this->_err_data;
    }

    /***
     * @return array
     */
    protected function getException()
    {
        if (empty($this->_exception_data)){
            $this->_exception_data = [];
        }
        return $this->_exception_data;
    }

    /***
     * @return array
     */
    protected function getSuccess()
    {
        if (empty($this->_success_data)){
            $this->_success_data = [];
        }
        return $this->_success_data;
    }
}