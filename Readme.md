# APP Toolkit
Hi Welcome to Toolkit , is completed create to make your code is very simple , let's contribute this repository just for dev to dev . 

## Feature Lists

 - [X] Auto Schedule Library



### BASIC USAGES

 - Auto Schedule Library
 
```
  
$load = new AutoSchendule();  
//Hari dalam Bentuk ANGKA  
$mockData = [  
	"process_by"=>AutoSchendule::PROCESS_BY_TIME,  
	"range_time"=>[  
		"excluded"=>[  
			"day"=>[0,1],  
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
```

# How To Contribute ? 

Just clone this repository  add whatever you want and let us to vote your code 
