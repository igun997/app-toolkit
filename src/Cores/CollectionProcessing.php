<?php
namespace igun997\Cores;

use AutoScedulingResponse;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use igun997\Middlewares\FlexibleTrait;
use igun997\Middlewares\Utilities;
use igun997\Objects\Entity;

class CollectionProcessing {
    use Utilities;
    use FlexibleTrait;
    CONST PROCESS_BY_TIME = 0;
    CONST PROCESS_BY_DIVISION = 1;
    protected function Scheduler(array $data,bool $is_random):array
    {
        $rules = [
            "process_by"=>"required|numeric",
            "data"=>"array",
            "data.*.id"=>"numeric|required",
            "data.*.name"=>"required",
            "data.*.hours"=>"required|numeric",
            "data.*.division_id"=>"required|numeric",
            "range_time"=>"required|array",
            "range_time.excluded"=>"required|array",
            "range_time.gap_on_hours"=>"required|numeric",
            "range_time.excluded.day"=>"required|array",
            "range_time.excluded.day.*"=>"required|numeric|in:0,1,2,3,4,5,6",
            "range_time.excluded.time_range"=>"required|array",
            "range_time.excluded.time_range.start"=>"required|numeric",
            "range_time.excluded.time_range.end"=>"required|numeric",
            "range_time.start"=>"required|numeric",
            "range_time.end"=>"required|numeric",
        ];
        $validator = $this->validator($data,$rules);
        if ($validator){
            return $this->getError();
        }
        $validated = $this->getSuccess();
        if ($is_random) {
            shuffle($validated["data"]);
        }
        switch ($validated["process_by"]){
            case CollectionProcessing::PROCESS_BY_TIME :

                return $this->process_by_time($validated);
                break;
            default:
                return [];
        }

    }

    private function process_by_time($data):array{
        $need_schenduler = $data["data"];
        $rules = $data["range_time"];
        $rangeDateFormat = [
            "start"=>Carbon::createFromTimestamp($rules["start"])->format("d-m-Y"),
            "end"=>Carbon::createFromTimestamp($rules["end"])->format("d-m-Y")
        ];
        $periodeObject  = CarbonPeriod::create($rangeDateFormat["start"],$rangeDateFormat["end"]);
        $rangeDateHuman = [];
        foreach ($periodeObject as $index => $item) {
            $rangeDateHuman[] = [
                "date"=>$item->format('d-m-Y'),
                "day"=>$item->format('w')
            ];
        }
        $this->storage = $rangeDateHuman;
        $cleanDayStrict = function ($strictDate) use ($rules){
            $data = $strictDate;
            foreach ($data as $index => &$datum) {
                if (in_array($datum["day"],$rules["excluded"]["day"])){
                    unset($data[$index]);
                }
            }
            return $data;
        };

        $rangeDateHuman = [];
        $this->operation($cleanDayStrict,$rangeDateHuman);

        $this->storage = $need_schenduler;
        $convertToObject = function ($items){
            $newRes = [];
            foreach ($items as $index => $item) {
                $item = (object) $item;
                $newRes[] = new Entity($item);
            }
            return $newRes;
        };
        $need_schenduler = [];
        $this->operation($convertToObject,$need_schenduler);

        $result = [];
        $this->storage = $need_schenduler;
        $scheduler = function ($data) use ($rules,$rangeDateHuman){
            $res = [];
            $completed_human = [];

            $gap_on_hours = ($rules["gap_on_hours"]*60)*60;
            foreach ($rangeDateHuman as $index1 => $human) {
                $res[$human["date"]] = [];
                $current_time = null;
                $endtime = null;
                foreach ($data as $index2 => $datum) {
                    if (!in_array($datum->id,$completed_human)){
                        $need = ($datum->hours*60)*60;
                        $start_from = strtotime($human["date"]." ".date("H:i:s",$rules["excluded"]["time_range"]["start"]));
                        $end_to = strtotime($human["date"]." ".date("H:i:s",$rules["excluded"]["time_range"]["end"]));

                        if ($current_time === NULL){
                            $current_time = $start_from;
                            $endtime = ($current_time+$need);
                        }else{
                            $current_time += ($gap_on_hours + $need);
                            $endtime = ($current_time+$need);
                        }
                        if ($endtime > $end_to){
                            continue;
                        }
                        $res[$human["date"]][] = [
                            "start"=>Carbon::createFromTimestamp($current_time)->format("d-m-Y H:i:s"),
                            "end"=>Carbon::createFromTimestamp($endtime)->format("d-m-Y H:i:s"),
                            "scheduler"=>$datum->toArray()
                        ];
                        $current_time = $endtime;
                        $completed_human[] = $datum->id;

                    }
                }
            }
            return $res;
        };
        $this->operation($scheduler,$result);

        $response = [];
        foreach ($result as $index => $item) {
            if (!empty($item)){
                $resp = [
                    "date"=>$index,
                    "data"=>$item
                ];
                $response[] = new AutoScedulingResponse($resp);
            }

        }
        

        return $response;
    }

}