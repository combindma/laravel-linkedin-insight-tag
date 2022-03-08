# LinkedIn Insight Tag integration for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/combindma/laravel-linkedin-insight-tag.svg?style=flat-square)](https://packagist.org/packages/combindma/laravel-linkedin-insight-tag)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/combindma/laravel-linkedin-insight-tag/run-tests?label=tests)](https://github.com/combindma/laravel-linkedin-insight-tag/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/combindma/laravel-linkedin-insight-tag/Check%20&%20fix%20styling?label=code%20style)](https://github.com/combindma/laravel-linkedin-insight-tag/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/combindma/laravel-linkedin-insight-tag.svg?style=flat-square)](https://packagist.org/packages/combindma/laravel-linkedin-insight-tag)

A complete Laravel package for LinkedIn Conversion Tracking

## Installation

You can install the package via composer:

```bash
composer require combindma/laravel-linkedin-insight-tag
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="linkedin-insight-tag-config"
```

This is the contents of the published config file:

```php
return [
    /*
     * LinkedIn Partner Id id provided by LinkedIn
     */
    'linkedin_partner_id' => env('LINKEDIN_PARTNER_ID', ''),

    /*
     * The key under which data is saved to the session with flash.
     */
    'sessionKey' => env('LINKEDIN_SESSION_KEY', config('app.name').'_linkedinInsightTag'),

    /*
     * Enable or disable script rendering. Useful for local development.
     */
    'enabled' => env('LINKEDIN_INSIGHT_TAG_ENABLED', false),
];
```


If you plan on using the [flash-functionality](#flashing-data-for-the-next-request) you must install the LinkedinInsightTagMiddleware, after the StartSession middleware:

```php
// app/Http/Kernel.php
protected $middleware = [
    ...
    \Illuminate\Session\Middleware\StartSession::class,
    \Combindma\LinkedinInsightTag\LinkedinInsightTagMiddleware::class,
    ...
];
``` 

## Usage

### Include scripts in Blade

Insert head view after opening head tag, and body view after opening body tag

```html
<!DOCTYPE html>
<html>
<head>
    @include('linkedinInsightTag::head')
</head>
<body>
@include('linkedinInsightTag::body')
</body>
```

Your conversion events will also be rendered here. To add an event, use the `conversion()` function.

```php
// HomeController.php
use Combindma\LinkedinInsightTag\Facades\LinkedinInsightTag;

public function index()
{
    LinkedinInsightTag::conversion('7652529'); //your conversion_id provided by Linkedin
    return view('home');
}
```

This renders:

```html
<html>
  <head>
    <script>/* Linkedin Insight Tag's base script */</script>
    <!-- ... -->
  </head>
  <body>
  <script>window.lintrk('track', { conversion_id: 7652529 });</script>
  <!-- ... -->
</html>
```

#### Flashing data for the next request

The package can also set event to render on the next request. This is useful for setting data after an internal redirect.

```php
// ContactController.php
use Combindma\LinkedinInsightTag\Facades\LinkedinInsightTag;

public function postContact()
{
    // Do contact form stuff...
    LinkedinInsightTag::flashConversion('7652529');
    return redirect()->action('ContactController@getContact');
}
```

After a form submit, the following event will be parsed on the contact page:

```html
<html>
<head>
    <script>/* Linkedin Insight Tag's base script */</script>
    <!-- ... -->
</head>
<body>
<script>window.lintrk('track', { conversion_id: 7652529 });</script>
<!-- ... -->
</html>
```

### Other Simple Methods

```php
use Combindma\LinkedinInsightTag\Facades\LinkedinInsightTag;

// Retrieve your Partner id
$id = LinkedinInsightTag::partnerId(); // XXXXXXXX
// Check whether script rendering is enabled
$enabled = LinkedinInsightTag::isEnabled(); // true|false
// Enable and disable script rendering on the fly
LinkedinInsightTag::enable();
LinkedinInsightTag::disable();
// Add conversion event to the conversion layer (automatically renders right before the tag script). Setting new values merges them with the previous ones.
LinkedinInsightTag::conversion(123456); //only int values
// Flash event for the next request. Setting new values merges them with the previous ones.
LinkedinInsightTag::flashConversion(123456);
//Clear the conversion layer.
LinkedinInsightTag::clear();
```

### Macroable

Adding conversion events to pages can become a repetitive process. Since this package isn't supposed to be opinionated on what your events should look like, the LinkedinInsightTag is macroable.

```php
use Combindma\LinkedinInsightTag\Facades\LinkedinInsightTag;

//include this in your macrobale file
LinkedinInsightTag::macro('purchase', function () {
    LinkedinInsightTag::conversion(123456);
    LinkedinInsightTag::conversion(654321);
});

//in your controller
LinkedinInsightTag::purchase();
```


## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Combind](https://github.com/combindma)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
