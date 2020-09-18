<?php
namespace Igun997\Toolkit\Objects;
class AutoScedulingResponse {
    public array $response;
    public string $date;

    protected $fields = [
        "response",
        "date"
    ];

    public function __construct(array $response)
    {
        $this->response = $response["data"];
        $this->date = $response["date"];
    }

    public function toArray()
    {
        $resp = [];
        foreach ($this->fields as $index => $field) {
            $resp[$field] = $this->$field;
        }
        return $resp;
    }
}