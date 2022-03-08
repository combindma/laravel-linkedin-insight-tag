<?php

namespace Combindma\LinkedinInsightTag;

use Illuminate\Support\Facades\View;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LinkedinInsightTagServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('linkedin-insight-tag')
            ->hasConfigFile('linkedin-insight-tag');
    }

    public function packageBooted()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'linkedinInsightTag');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/combindma'),
        ], 'views');

        View::creator(
            ['linkedinInsightTag::head', 'linkedinInsightTag::body'],
            'Combindma\LinkedinInsightTag\ScriptViewCreator'
        );
    }

    public function registeringPackage()
    {
        $this->app->singleton(LinkedinInsightTag::class, function () {
            return new LinkedinInsightTag();
        });
    }
}
