<?php

namespace Fjord;

use Fjord\Crud\Config\CrudConfig;
use Fjord\Application\Application;
use Fjord\Crud\Config\Traits\HasCrudForm;
use Fjord\User\Components\UsersComponent;
use Fjord\Crud\Config\Traits\HasCrudIndex;
use Fjord\Crud\Vue\Components\CrudShowComponent;
use Fjord\Crud\Vue\Components\CrudIndexComponent;
use Fjord\Crud\Config\Factories\CrudConfigFactory;
use Fjord\Application\Package\FjordPackage as Package;
use Fjord\Crud\Config\Factories\CrudFormConfigFactory;
use Fjord\Crud\Config\Factories\CrudIndexConfigFactory;
use Fjord\Application\Navigation\NavigationConfigFactory;
use Fjord\Application\Navigation\Config as NavigationConfig;

class FjordPackage extends Package
{
    /**
     * List of service providers to be registered for this package.
     * 
     * @var array
     */
    protected $providers = [
        \Fjord\Application\Translation\TranslationServiceProvider::class,
        \Fjord\Application\ApplicationRouteServiceProvider::class,
        \Fjord\User\ServiceProvider::class,
        \Fjord\Crud\ServiceProvider::class,
    ];

    /**
     * List of all artisan commands to be registered for this package.
     *
     * @var array
     */
    protected $commands = [
        Commands\FjordNav::class,
        Commands\FjordAdmin::class,
        Commands\FjordUser::class,
        Commands\FjordCrud::class,
        Commands\FjordForm::class,
        Commands\FjordExtend::class,
        Commands\FjordExtension::class,
        Commands\FjordDefaultPermissions::class,
    ];

    /**
     * List of extendable root Vue components this package contains.
     * 
     * @var array
     */
    protected $components = [
        'fj-users' => UsersComponent::class,
        'fj-crud-index' => CrudIndexComponent::class,
        'fj-crud-show' => CrudShowComponent::class,
    ];

    /**
     * List of config classes with their associated factories.
     * 
     * @var array
     */
    protected $configFactories = [
        NavigationConfig::class => NavigationConfigFactory::class,
        CrudConfig::class => CrudConfigFactory::class,
        HasCrudForm::class => CrudFormConfigFactory::class,
        HasCrudIndex::class => CrudIndexConfigFactory::class,
    ];

    /**
     * Boot application.
     *
     * @param Application $app
     * @return void
     */
    public function boot(Application $app)
    {
        $app->addCssFile('/' . config('fjord.route_prefix') . '/css/app.css');

        foreach (config('fjord.assets.css') as $path) {
            $app->addCssFile($path);
        }
    }
}
