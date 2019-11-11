<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;
use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      // mysqlの効果方法不明
      // if (\DB::getDriverName() === 'mysqli') {
      //   \DB::statement(\DB::raw('PRAGMA foreign_keys=1'));
      // }

      // 商用環境以外だった場合、SQLログを出力する
      // if (config('app.env') !== 'production') {
      //     DB::listen(function ($query) {
      //         \Log::info("Query Time:{$query->time}s] $query->sql");
      //     });
      // }
      DB::listen(function ($query) {
        \Log::info("Query Time:{$query->time}s] $query->sql");
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\MeigaraService');
    }

}
