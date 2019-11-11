<?php

// scraping・バッチ実行用のclass
namespace App\Console\Commands;

use Illuminate\Console\Command;
//MeigaraのModelを指定することでここのTableにデータを格納する。
use App\MeigaraList;

class ScrapeListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ScrapeListCommand';

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

        //別のページからテスト
        // 3「東京の過去36時間の天気」テーブルを指定
        $dom = $crawler->filter('table')->eq(0)->filter('td');

        $ary = array(); // 「現地時間」、「天気」の保存用
        $time = "";     // 「現地時間」の一時保管用
        $ix = 0;        // 現在行

        // 4テーブルから1行ずつ取得する
        $dom->each(function ($node) use (&$ix, &$time, &$ary) {

          //いらない注釈が5tdあるので除外。
          if ( $ix >= 5){
            // 5「現地時間」を取得する
            if (($ix % 4 - 1)==0) {
              $time = $node->text();
            }
            // 6「天気」を取得する
            else if ((($ix) % 4 - 2)==0) {
              $ary[ $time ] = $node->text();
            }
          }
          $ix++;
        });
        // 7現地時間、天気を表示する
        foreach ($ary as $t => $w){
          echo $t. "+". $w."\n";
          $meigaraList = new MeigaraList;
          $meigaraList->meigaraCode = $t;
          $meigaraList->meigaraName = $w;
          $meigaraList->save();
        }

        //別のページからテスト




        // $tr = $crawler->filter('table')->eq(0)->filter('tr')->eq(3)->each(function($element){
        //   $meigaraList = new MeigaraList;
        //   if(count($element->filter('td'))){
        //     // echo $element->filter('td')->eq(1)->text()."\n";
        //     $meigaraList->meigaraCode = $element->filter('td')->eq(0)->text()."\n";
        //     $meigaraList->meigaraName = $element->filter('td')->eq(1)->text()."\n";
        //     $meigaraList->joujouKbnName = $element->filter('td')->eq(2)->text()."\n";
        //     $meigaraList->meigaraNameYomi = $element->filter('td')->eq(3)->text()."\n";
        //     $meigaraList->save();
        //   }
        // });
        $tdMeigaraCode = array();
        $tdMeigaraName = array();
        $tdJoujouKbnName = array();
        $tdMeigaraNameYomi = array();

        // $tr = $crawler->filter('table')->eq(0)->filter('tr')->each(function($element){
        //   if(count($element->filter('td'))){
        //     //うまくいく
        //     // return $element->filter('td')->eq(0)->text().",";
        //     // return $element->filter('td')->eq(1)->text();
        //     // NG
        //     // return $element->filter('td')->eq(1)->text().",";
        //     //うまくいく
        //     return $element->text();
        //   }
        // });
        // echo "ここで終了";
        // var_dump( $tr );
        //ここからうまくいかない。
        // for($i = 2; $i ≦ sizeof($tdMeigaraCode); $i++){
        //   $meigaraList = new MeigaraList;
        //   $meigaraList->meigaraCode = $tdMeigaraCode($i);
        //   $meigaraList->meigaraName = $tdMeigaraName($i);
        //   $meigaraList->joujouKbnName = $tdJoujouKbnName($i);
        //   $meigaraList->meigaraNameYomi = $tdMeigaraNameYomi($i);
        // }
      }

      $siteurl = "http://www.kabu-data.info/all_code/code_tosyo1_code.htm";
      dbsave($siteurl);
    }
}
