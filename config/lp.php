<?php

return [
	'daystring' =>
		[
			'Monday' => '月曜日',
			'Tuesday' => '火曜日',
			'Wednesday' => '水曜日',
			'Thursday' => '木曜日',
			'Friday' => '金曜日',
			'Saturday' => '土曜日',
			'Sunday' => '日曜日',
		],

	'budget' =>
		[
			'hour' => '1時間あたり',
			'day' => '1日あたり',
			'month' => '1ヶ月あたり',
			'week' => '1週間あたり',
		],

	'budgetType' =>
		[
			'1' =>[
				'id' => '1',
				'displayEN' => 'Hourly',
				'display' => '時間毎',
				'type' => 'type-group-c',
				'fee' => 'fee-group-a',
			],
			'2' =>[
				'id' => '2',
				'displayEN' => 'Daily',
				'display' => '日毎',
				'type' => 'type-group-a',
				'fee' => 'fee-group-b',
			],
			'3' =>[
				'id' => '3',
				'displayEN' => 'Weekly',
				'display' => '週毎',
				'type' => 'type-group-b',
				'fee' => 'fee-group-c',
			],
			'4' =>[
				'id' => '4',
				'displayEN' => 'Monthly',
				'display' => '月毎',
				'type' => 'type-group-b',
				'fee' => 'fee-group-d',
			],
		],
	'spaceArea' =>
	[
		'1' =>[
			'id' => '1',
			'start' => '1',
			'end' => '10',
			'display' => '10m²以下',
		],
		'2' =>[
			'id' => '2',
			'start' => '1',
			'end' => '20',
			'display' => '20m²以下',
		],
		'3' =>[
			'id' => '3',
			'start' => '30',
			'end' => '10000000',
			'display' => '30m²以上',
		],
		'4' =>[
			'id' => '4',
			'start' => '0',
			'end' => '100000000',
			'display' => '広さ指定なし',
		],
	],

	'SearchBudgets' =>
	[
		'1' =>[
			'id' => '1',
			'start' => '0',
			'end' => '2000',
			'display' => '¥2,000以下',
			'type' => 'hour',
		],
		'2' =>[
			'id' => '2',
			'start' => '2001',
			'end' => '5000',
			'display' => '¥2,001~¥5,000',
			'type' => 'hour',
		],
		'3' =>[
			'id' => '3',
			'start' => '5001',
			'end' => '10000',
			'display' => '¥5,001~¥10,000',
			'type' => 'hour',
		],
		'4' =>[
			'id' => '4',
			'start' => '10001',
			'end' => '100000000',
			'display' => '¥10,000以上',
			'type' => 'hour',
		],
		'5' =>[
			'id' => '5',
			'start' => '0',
			'end' => '3000',
			'display' => '¥3,000以下',
			'type' => 'day',
		],
		'6' =>[
			'id' => '6',
			'start' => '3001',
			'end' => '5000',
			'display' => '¥3,001~¥5,000',
			'type' => 'day',
		],
		'7' =>[
			'id' => '7',
			'start' => '5001',
			'end' => '10000',
			'display' => '¥5,001~¥10,000',
			'type' => 'day',
		],
		'8' =>[
			'id' => '8',
			'start' => '10001',
			'end' => '100000000',
			'display' => '¥10,000以上',
			'type' => 'day',
		],
	],	
];
