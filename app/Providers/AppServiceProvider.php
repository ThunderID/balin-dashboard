<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade, Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('date_indo', function($expression) 
        {
            return "<?php echo with{$expression}->format('d-m-Y'); ?>";
        });

        Blade::directive('date_with_name_month_indo', function($expression) 
        {
            return "<?php echo with{$expression}->format('d-M-Y'); ?>";
        });

        Blade::directive('datetime_indo', function($expression) 
        {
            return "<?php echo with{$expression}->format('d-m-Y H:i'); ?>";
        });

        Blade::directive('datetime_with_name_month_indo', function($expression) 
        {
            return "<?php echo with{$expression}->format('d F Y  |  H:i'); ?>";
        });

        Blade::directive('money_indo', function($expression)
        {
            return "<?php echo 'IDR '.number_format($expression, 0, ',', '.'); ?>";
        });

        Blade::directive('money_indo_negative', function($expression)
        {
            return "<?php echo 'IDR -'.number_format($expression, 0, ',', '.'); ?>";
        });

        Blade::directive('money_indo_for_email', function($expression)
        {
            return "<?php echo number_format($expression, 0, ',', '.'); ?>";
        });
     }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
