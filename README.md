# laravel-sms

## Installation

### Install package

~~~bash
composer require huangdijia/laravel-sms
~~~

## Install configure

~~~bash
php artisan sms:install
~~~

## Uage

## Simple to send a message

~~~php
use Huangdijia\Sms\Facades\Sms;

Sms::to('phone number')->content('message content')->send();
~~~

### Check send result

~~~php
$response = Sms::to('phone number')->content('message content')->send();

if ($response->successful()) {
    // success
}
~~~

### Throwing Exceptions

~~~php
$response = Sms::to('phone number')->content('message content')->send();

$response->throw();
~~~

### Switch sms factory

~~~php
Sms::driver('another')->to('phone number')->content('message content')->send();
~~~

### With Validate Rules

~~~php
Sms::withRules([
    'to'      => 'required|numeric|....',
    'content' => 'required|...',
], [
    'to.required'      => ':attribute cannot be empty!',
    'content.required' => ':attribute cannot be empty!',
    // more messages
])->to()->content()->send();
~~~
