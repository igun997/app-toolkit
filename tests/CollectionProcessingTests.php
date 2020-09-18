<?php
require "../vendor/autoload.php";
use igun997\Modules\AutoSchendule;
use Igun997\Utility\Debug;

$loader = new Nette\Loaders\RobotLoader;

$loader->addDirectory('../src');
$loader->setTempDirectory(__DIR__ . '/temp');
$loader->register();

$load = new AutoSchendule();
//Hari dalam Bentuk ANGKA
$mockData = [
    "process_by"=>AutoSchendule::PROCESS_BY_TIME,
    "range_time"=>[
        "excluded"=>[
          "day"=>[
              0,1
          ],
          "time_range"=>[
              "start"=>strtotime("2020-01-01 7:00"),
              "end"=>strtotime("2020-01-01 13:00")
          ]
        ],
        "gap_on_hours"=>0.5,
        "start"=>time(),
        "end"=>(time()+(3600*200))
    ],
    "data"=>[
        [
            "id"=>1,
            "division_id"=>1,
            "name"=>"Employee A",
            "hours"=>5
        ],
        [
            "id"=>2,
            "division_id"=>1,
            "name"=>"Employee B",
            "hours"=>1
        ],
        [
            "id"=>3,
            "division_id"=>1,
            "name"=>"Employee C",
            "hours"=>1
        ],
        [
            "id"=>4,
            "division_id"=>1,
            "name"=>"Employee D",
            "hours"=>1
        ],
        [
            "id"=>5,
            "division_id"=>1,
            "name"=>"Employee E",
            "hours"=>5
        ]
    ]
];
$load->setData($mockData);
$response = $load->run(TRUE)->getData();

Debug::log($response);