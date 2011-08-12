EJuiTimePicker
==============

EJuiTimePicker is an axtension for Yii framework. This extension is a wrapper for [Timepicker addon](http://trentrichardson.com/examples/timepicker/ "Timepicker addon") which adds a timepicker to jQuery UI Datepicker.

This extension is based on [CJuiDateTimePicker extension](http://www.yiiframework.com/extension/datetimepicker/ "CJuiDateTimePicker extension"), hovewer it has different widget call (prefix of 'C' might get confusing in the future) and few other tricks up its sleeve.

Requirements
------------

* Yii 1.1 or above (tested on 1.1.8)
* jQuery
* jQuery UI (datepicker and slider components)

Installation
------------

Move **EJuiTimePicker** folder in your applications extensions folder (default: `protected/extensions`).

Using extension
---------------

Just place the following code inside your view file:

```php
<?php $this->widget( 'ext.EJuiTimePicker.EJuiTimePicker', array(
  'model' => $model, // Your model
  'attribute' => 'end_date', // Attribute for input
)); ?>
```

You can also change some default settings (more on this later).

Widget Factory
--------------

To make your life easier, you can configure `widgetFactory` component with some default options (all the options can be set for widget which will overwrite `widgetFactory` option). Change your `main.php` config file to look similarly to this:

```php
'components' => array(
  'widgetFactory' => array(
    'widgets' => array(
      'EJuiTimePicker' => array(
        'options' => array(
          'dateFormat' => 'yy-mm-dd',
          'showOn' => 'both',
          'buttonText' => 'Open calendar',
          // Any other option from http://jqueryui.com/demos/datepicker/
          // Or http://trentrichardson.com/examples/timepicker/
        ),
        'timeOptions' => array(
          'showOn' => 'focus',
        ),
        'htmlOptions' => array(
          'autocomplete' => 'off',
          'size' => 10,
          'maxlength' => 10,
        ),
        'timeHtmlOptions' => array(
          'size' => 5,
          'maxlength' => 5,
        ),
        'language' => 'lt',
        'mode' => 'date',
      ),
    ),
  ),
),
```

* **options** sets the options for jquery addon. All available options can be found on [jQuery Datepicker](http://jqueryui.com/demos/datepicker/ "jQuery Datepicker") and [Timepicker addon](http://trentrichardson.com/examples/timepicker/ "Timepicker addon") pages.
* **timeOptions** is an array with options which will be overwrited when using only timepicker (for example you want to replace icon from calendar to a clock).
* **htmlOptions** is an array with html options for input.
* **timeHtmlOptions** is an array with html options for input which will be overwriten when using only timepicker (for example you want to make it smaller so only hour and minutes can be inputed).
* **language** localization string. This will try to add localization file if it is found (localization files are provided by addon, you can make your own).
* **mode** this is a mode of the extension. Allowed options: `date` (will only add date picker), `time` (will only add time picker), `datetime` (will add both. This is default value).

Resources
---------

* [Timepicker addon (contains demos)](http://trentrichardson.com/examples/timepicker/ "Timepicker addon")

Notes
-----

* For your convenience extension contains Timepicker addon. Hovewer to make sure you have the newest addon you should download it from [Timepicker addon Git repository](https://github.com/trentrichardson/jQuery-Timepicker-Addon "Timepicker addon Git repository")