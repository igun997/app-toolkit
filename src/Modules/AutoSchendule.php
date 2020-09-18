<?php
namespace igun997\Modules;

use igun997\Contract\AutoScenduleContract;
use igun997\Cores\CollectionProcessing;
use igun997\Middlewares\AutoSchenduleTrait;

class AutoSchendule extends CollectionProcessing implements AutoScenduleContract {
    use AutoSchenduleTrait;


    public function setData(array $data): void
    {
       $this->rawData = $data;
    }

    public function run(bool $is_random = FALSE)
    {
        $finalize_data = $this->Scheduler($this->rawData,$is_random);
        $this->finalizeData[] = $finalize_data;
        return $this;
    }

    public function getData(): array
    {
       return $this->finalizeData;
    }

}