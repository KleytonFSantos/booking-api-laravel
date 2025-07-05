<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Contracts\Services\UploadFileServiceInterface',
            'App\Services\Document\UploadFileServiceService'
        );

        $this->app->bind(
            'App\Contracts\Services\CreateBookingServiceInterface',
            'App\Services\Booking\CreateBookingService'
        );

        $this->app->bind(
            'App\Contracts\Repositories\RoomRepositoryInterface',
            'App\Repositories\RoomRepository'
        );

        $this->app->bind(
            'App\Contracts\Repositories\ReservationRepositoryInterface',
            'App\Repositories\ReservationRepository'
        );

        $this->app->bind(
            'App\Contracts\Validator\BookingValidatorInterface',
            'App\Validator\BookingValidator'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
