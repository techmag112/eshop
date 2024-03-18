<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
      //  $this->app->singleton(Generator::class, function () {
      //      $faker = Factory::create();
      //      $faker->addProvider(new FakerImageProvider($faker));
      //      return $faker;
      //  });
    }

    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());
        // Теперь включает:
        //Model::preventLazyLoading(!app()->isProduction());
        //Model::preventSilentlyDiscardingAttributes(!app()->isProduction());
        //Model::preventAccessingMissingAttributes();

        if(app()->isProduction()) {

            //DB::whenQueryingForLongerThan(CarbonInterval::seconds(5), function (Connection $connection) {
            //    logger()
            //        ->channel('telegram')
            //        ->debug('whenRequestLifecycleIsLongerThan ' . $connection->totalQueryDuration());
            //});

            DB::listen(function ($query) {
                if ($query->time > CarbonInterval::seconds(1)) {
                    logger()
                        ->channel('telegram')
                        ->debug('Query longer than 1s '. $query->sql, $query->bindings);
                }
            });

           // $kernel = app(Kernel::class);
            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()
                        ->channel('telegram')
                        ->debug('whenRequestLifecycleIsLongerThan ' . request()->url());
                }
            );
        }
    }
}
