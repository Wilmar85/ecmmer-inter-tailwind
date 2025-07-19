<?php

namespace App\Providers;

use App\Helpers\ContactHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('contactInfo', ContactHelper::getContactInfo());
        });
    }
}
