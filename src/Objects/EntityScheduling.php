<?php

namespace Igun997\Toolkit\Objects;
/***
 * Class Entity
 * @package igun997\Objects
 */
class EntityScheduling {
    public $id;
    public String $name;
    public int $division_id;
    public int $hours;
    public ?array $schedule;

    protected $fields = [
        "id",
        "name",
        "division_id",
        "hours",
        "schedule"
    ];

    /***
     * Entity constructor.
     * @param Object $data
     */
    public function __construct(Object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->hours = $data->hours;
        $this->division_id = $data->division_id;
        $this->schedule = ((isset($data->schedule))?$data->schedule:NULL);
    }

    /***
     * @return array
     */
    public function toArray()
    {
        $response = [];
        foreach ($this->fields as $index => $field) {
            $response[$field] = $this->$field;
        }
        return $response;
    }
}