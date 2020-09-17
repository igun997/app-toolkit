<?php
namespace igun997\Cores;

use igun997\Middlewares\Utilities;

class CollectionProcessing {
    use Utilities;
    CONST PROCESS_BY_TIME = 0;
    CONST PROCESS_BY_DIVISION = 1;
    protected function Scheduler(array $data):array
    {
        $rules = [
            "process_by"=>"required|numeric",
            "data"=>"array",
            "data.*.id"=>"numeric|required",
            "data.*.name"=>"required",
            "data.*.division_id"=>"required|numeric",
        ];
        $validator = $this->validator($data,$rules);
        if ($validator){
            return $this->getError();
        }
        $validated = $this->getSuccess();
        return $validated;
    }

}