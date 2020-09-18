<?php
namespace Igun997\Toolkit\Modules;



use Igun997\Toolkit\Contract\AutoScenduleContract;
use Igun997\Toolkit\Cores\CollectionProcessing;
use Igun997\Toolkit\Middlewares\AutoSchenduleTrait;

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