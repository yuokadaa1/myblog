<?php

// scraping・バッチ実行用のclass
namespace App\Console\Commands;

use Illuminate\Console\Command;
//MeigaraのModelを指定することでここのTableにデータを格納する。
use App\Meigara;
use App\MeigaraList;

class ScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    //コマンド名を設定（元：command:name→変更後：command:scrapecommand）
    //php artisan list で出てくる名前
    protected $signature = 'command:scrapecommand';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    //コマンドの説明（元：Command description→変更後：scrapecommandのコマンド説明）
    protected $description = 'scrapecommandのコマンド説明';

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
      // function dbsave($url){
      function dbsave($meigaraCode,$url){

        $crawler = \Goutte::request('GET', $url);

        //li に年度データがあるのをすべて回収
        //https://kabuoji3.com/stock/7203/2018/
        $li = $crawler->filter('a')->each(function($element) use ($url,$meigaraCode){
              //$element->attr('href')が$urlから始る（前方一致）
              if (0 === strpos($element->attr('href'), $url)) {

                //meigaraCodeに対する年次リストの取得
                echo $element->attr('href')."に対するアクセス開始。"."\n";
                $crawlerLi = \Goutte::request('GET', $element->attr('href'));

                //URLがあったらそれをDBに格納。
                $td = $crawlerLi->filter('table')->eq(0)->filter('tr')->each(function($element) use ($meigaraCode){

                  if(count($element->filter('td'))){

                     Meigara::unguard(); // セキュリティー解除
                     $meigara = Meigara::updateOrCreate(
                      ['meigaraCode' => $meigaraCode,
                      'meigaraCodeA' => '',
                      'date' => $element->filter('td')->eq(0)->text()],
                      ['openingPrice' => $element->filter('td')->eq(1)->text(),
                        'highPrice' => $element->filter('td')->eq(2)->text(),
                        'lowPrice' => $element->filter('td')->eq(3)->text(),
                        'closingPrice' => $element->filter('td')->eq(4)->text()
                      ]
                    );
                    Meigara::reguard(); // セキュリティーを再設定
                    
                  }
                });

              }
        });
      }

      //取得する銘柄コード一覧をTBLから取得(ScrapeListCommandで登録済)
      $meigaralist = MeigaraList::select('meigaraCode')->get();

      //取得した銘柄コードでサイトアクセスして登録を回す
      foreach($meigaralist as $key=>$meigara){
        $siteurl = "https://kabuoji3.com/stock/".$meigara['meigaraCode']."/";
        // Config::set(['user' => ['name' => $meigara['meigaraCode']]]);
        echo "実行開始：".$meigara['meigaraCode']."\n";
        dbsave($meigara['meigaraCode'],$siteurl);
      }
      // $siteurl = "https://kabuoji3.com/stock/7203/";
      // dbsave($siteurl);
  }
}
