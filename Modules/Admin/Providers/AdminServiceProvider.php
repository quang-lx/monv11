<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Admin\Console\CreateAdminUser;
use Modules\Admin\Console\GenerateAdminPermission;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $commands = [
        CreateAdminUser::class,
        GenerateAdminPermission::class
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->registerBindings();
        $this->commands($this->commands);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('admin.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'admin'
        );

    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/admin');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admin';
        }, \Config::get('view.paths')), [$sourcePath]), 'admin');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/admin');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admin');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'admin');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
    private function registerBindings()
    {


        $this->app->bind(
            'Modules\Admin\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Mon\Entities\Category());
                return $repository;
            }
        );

        $this->app->bind(
            'Modules\Admin\Repositories\DepartmentRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentDepartmentRepository(new \Modules\Mon\Entities\Department());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\DepartmentRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentDepartmentRepository(new \Modules\Mon\Entities\Department());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\ConfigDisplayRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentConfigDisplayRepository(new \Modules\Mon\Entities\ConfigDisplay());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\DeviceRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentDeviceRepository(new \Modules\Mon\Entities\Device());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\TestingServiceRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentTestingServiceRepository(new \Modules\Mon\Entities\TestingService());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\ServiceIndexRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentServiceIndexRepository(new \Modules\Mon\Entities\ServiceIndex());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\DiseaseRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentDiseaseRepository(new \Modules\Mon\Entities\Disease());
                return $repository;
            }
        );

        $this->app->bind(
            'Modules\Admin\Repositories\PatientRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentPatientRepository(new \Modules\Mon\Entities\Patient());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\ServiceTypeRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentServiceTypeRepository(new \Modules\Mon\Entities\ServiceType());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\PatientExaminationRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentPatientExaminationRepository(new \Modules\Mon\Entities\PatientExamination());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\ExaminationServiceRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentExaminationServiceRepository(new \Modules\Mon\Entities\ExaminationService());
                return $repository;
            }
        );
        $this->app->bind(
            'Modules\Admin\Repositories\ExaminationHealthRepository',
            function () {
                $repository = new \Modules\Admin\Repositories\Eloquent\EloquentExaminationHealthRepository(new \Modules\Mon\Entities\ExaminationHealth());
                return $repository;
            }
        );
// add bindings





















    }
}
