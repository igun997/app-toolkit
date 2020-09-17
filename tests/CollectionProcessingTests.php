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
              7,8
          ],
          "time_range"=>[
              [
                  "start"=>time(),
                  "end"=>time()
              ]
          ]
        ],
        "start"=>time(),
        "end"=>(time()+(3600*200))
    ],
    "data"=>[
        [
            "id"=>1,
            "division_id"=>1,
            "name"=>"Penjadwalan"
        ]
    ]
];
$load->setData($mockData);
$response = $load->run()->getData();

Debug::log($response);