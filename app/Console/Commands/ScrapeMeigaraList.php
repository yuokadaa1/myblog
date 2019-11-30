<?php

// scraping・バッチ実行用のclass
namespace App\Console\Commands;

use Illuminate\Console\Command;
//MeigaraのModelを指定することでここのTableにデータを格納する。
use App\MeigaraList;

class ScrapeMeigaraList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ScrapeMeigaraList';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '東証コード一覧を取得してTABLEに格納するcommand';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      // ここに処理を記述
      function dbsave($url){

        //データ取得
        $crawler = \Goutte::request('GET', $url);
        $tr = $crawler->filter('table')->eq(0)->filter('tr')->each(function($element){
          if(count($element->filter('td'))){
            //何か余計なものがあるのでtrのtd１個目が東コード(4桁)か判定
            if(mb_strlen($element->filter('td')->eq(0)->text()) == 4){
              MeigaraList::unguard(); // セキュリティー解除
              $meigaraList = MeigaraList::updateOrCreate(
                ['meigaraCode' => $element->filter('td')->eq(0)->text()],
                ['meigaraName' => $element->filter('td')->eq(1)->text(),
                'joujouKbnName' => $element->filter('td')->eq(2)->text(),
                'meigaraNameYomi' => $element->filter('td')->eq(3)->text()
              ]
            );
            MeigaraList::reguard(); // セキュリティーを再設定
            }
          }
        });
      }

      $siteurl = "http://www.kabu-data.info/all_code/code_tosyo1_code.htm";
      dbsave($siteurl);
    }
}
