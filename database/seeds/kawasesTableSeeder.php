<?php

use Illuminate\Database\Seeder;

class kawasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // テーブルのクリア
      DB::table('kawases')->truncate();

      // 初期データ用意（列名をキーとする連想配列）
      $kawaseD = [
          ['base' => 'USD',
           'pair' => 'JPY',
           'date' => '2019-10-10',
           'time' => '150000',
           'rate' => 150.000
          ],
          ['base' => 'USD',
           'pair' => 'JPY',
           'date' => '2019-10-10',
           'time' => '151000',
           'rate' => 151.000
          ],
          ['base' => 'USD',
           'pair' => 'JPY',
           'date' => '2019-10-10',
           'time' => '152000',
           'rate' => 152.000
          ],
          ['base' => 'USD',
           'pair' => 'JPY',
           'date' => '2019-10-10',
           'time' => '153000',
           'rate' => 153.000
          ],
          ['base' => 'USD',
           'pair' => 'JPY',
           'date' => '2019-10-10',
           'time' => '154000',
           'rate' => 154.000
          ],
          ['base' => 'USD',
           'pair' => 'JPY',
           'date' => '2019-10-10',
           'time' => '155000',
           'rate' => 155.000
          ],
          ['base' => 'USD',
           'pair' => 'JPY',
           'date' => '2019-10-10',
           'time' => '160000',
           'rate' => 160.000
          ],
          ['base' => 'USD',
           'pair' => 'JPY',
           'date' => '2019-10-10',
           'time' => '161000',
           'rate' => 161.000
          ]
        ];

        // 登録
        foreach($kawaseD as $kawase) {
          \App\Kawase::create($kawase);
        }
    }
}
