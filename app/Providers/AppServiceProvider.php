<?php

namespace App\Providers;

use App\Contracts\AdoptionService;
use App\Contracts\AnimalService;
use App\Contracts\PetPictureService;
use App\Contracts\PetService;
use App\Contracts\UserService;
use App\Models\Animal;
use App\Policies\AnimalPolicy;
use App\Services\AdoptionServiceImpl;
use App\Services\AnimalServiceImpl;
use App\Services\PetPictureServiceImpl;
use App\Services\PetServiceImpl;
use App\Services\UserServiceImpl;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AdoptionService::class, AdoptionServiceImpl::class);
        $this->app->bind(AnimalService::class, AnimalServiceImpl::class);
        $this->app->bind(PetPictureService::class, PetPictureServiceImpl::class);
        $this->app->bind(PetService::class, PetServiceImpl::class);
        $this->app->bind(UserService::class, UserServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function($query) {
            Log::info(
                $query->sql,
                [
                    'bindings' => $query->bindings,
                    'time' => $query->time
                ]
            );
        });

        \Illuminate\Support\Facades\Gate::policy(Animal::class, AnimalPolicy::class);

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
