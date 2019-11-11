<?php

use Illuminate\Database\Seeder;

class meigaraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // テーブルのクリア
      DB::table('meigaras')->truncate();

      // 初期データ用意（列名をキーとする連想配列）
      $meigaraD = [
          ['meigaraCode' => '7203',
           'date' => '2019-10-11',
           'openingPrice' => 7200,
           'highPrice' => 7278,
           'lowPrice' => 7160,
           'closingPrice' => 7269,
           'volume' => 4755500
          ],
          ['meigaraCode' => '7203',
            'date' => '2019-10-10',
            'openingPrice' => 7105,
            'highPrice' => 7012,
            'lowPrice' => 7012,
            'closingPrice' => 7108,
            'volume' => 3617500
          ],
          ['meigaraCode' => '7203',
           'date' => '2019-10-09',
           'openingPrice' => 7036,
           'highPrice' => 7141,
           'lowPrice' => 7031,
           'closingPrice' => 7125,
           'volume' => 4903400
          ],
          ['meigaraCode' => '7203',
            'date' => '2019-10-08',
            'openingPrice' => 7020,
            'highPrice' => 7104,
            'lowPrice' => 7015,
            'closingPrice' => 7087,
            'volume' => 4833500
          ]
        ];

        // 登録
        foreach($meigaraD as $meigara) {
          \App\meigara::create($meigara);
        }
    }
}
