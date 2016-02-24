# Slick Form package

[![Latest Version](https://img.shields.io/github/release/slickframework/form.svg?style=flat-square)](https://github.com/slickframework/form/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/slickframework/form/master.svg?style=flat-square)](https://travis-ci.org/slickframework/form)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/slickframework/form/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/slickframework/form/code-structure?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/slickframework/form/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/slickframework/form?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/slick/form.svg?style=flat-square)](https://packagist.org/packages/slick/form)

`Slick/Form` is a package that helps you work with HTML forms. It allows form creation,
input validation and filtering and also helps rendering it as HTML in your views.
The goal is to create a `Form` object that can be worked in the different stages of an
HTTP request.

This package is compliant with PSR-2 code standards and PSR-4 autoload standards. It
also applies the [semantic version 2.0.0](http://semver.org) specification.

## Install

Via Composer

``` bash
$ composer require slick/form
```

## Usage

One of the greatest features of `Slick/Form` package is to facilitate the creation
and usage of HTML forms. You probably will need forms in your application and
you will need to create all the HTML for every input, validate that input in
submission process and filter the input before using it.

`Slick/Form` helps you with that. All you need is to define your form and its
validators and filters and you will have HTML rendering, input validation and
filter.

### Form definition

Lets start with a very simple example: A login form (`login-form.yml`)

```yaml
id: login-form
elements:
  username:
    type: text
    label: Username
    validates:
      notEmpty: Username cannot be empty
    filters:
      - text
  password:
    type: password
    label: Password
    validates:
      notEmpty: Password cannot be empty
  remember:
      type: checkbox
      label: Remember me on this computer
      filters:
        - boolean
  buttonGroup:
    type: fieldset
    elements:
      submit:
        type: submit
        value: Sign in
        attributes:
          class: btn btn-primary
```
In your application controller

```php
use Slick\Form\FormRegistry;

class LoginController
{
    public function login()
    {
        $form = FormRegistry::getForm('login-form.yml');
        return compact('form');
    }
}
```

### Form HTML rendering

And in your view:

```html
<html>
<head>
    <title>Login form</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="form-wrapper">
      <?php print $form; ?>
    </div>
</body>
```

the result should be as follows:


![Form output](https://raw.githubusercontent.com/slickframework/form/master/img/login-1.png)


### Form submission/validation

Now with our form in place we need to detect if the form was submitted and
if its valid:

```php
use Slick\Form\FormRegistry;

class LoginController
{
    public function login()
    {
        $form = FormRegistry::getForm('login-form.yml');
        if ($form->wasSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getValues();  // An associative array with submitted values
                // Do stuff with the values
            } else {
                // data is not valid
            }
        }
        return compact('form');
    }
}
```

The `Form::wasSubmitted()` and `Form::isValid()` methods encapsulate the retrieve
of submitted data and the validation process through all input validation chains.

The `Form::getValues()` will return an associative array with submitted values
filtered. For example the `$data['remember']` is a `Boolean` value because it will
use the `boolean` filter as we set in the `login-form.yml` definitions file. 

## Testing

``` bash
$ vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email silvam.filipe@gmail.com instead of using the issue tracker.

## Credits

- [Slick framework](https://github.com/slickframework)
- [All Contributors](https://github.com/slickframework/common/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.