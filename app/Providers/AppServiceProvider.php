<?php

namespace App\Providers;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('naira', function ($amount) {
            return "<?php echo '&#8358;' . number_format($amount, 2); ?>";
        });

        View::composer('admin.app', function ($view) {
            $view->with('unreadMessages', ContactMessage::where('is_read', false)->count());
        });
    }
}
