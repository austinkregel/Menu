# What is it?
This is an menu generator build with Laravel and Bootstrap in mind

# Set up
 1. `composer require kregel/menu` or add  `"kregel/menu": "dev-master"` to your composer.json file.
 2. Register the service provider with your `config/app.php` file.
 
 ```php
  'providers' => [
    ...,
    Kregel\Menu\MenuServiceProvider::class,
    ...,
  ]
```

 3. Which ever blade file is storing your current nav set up just add two lines of code to it and replace the majority of your file...

 At the top add

 ```php
@inject('menu', 'Kregel\Menu\Menu')
 ```
 
and where ever you start your list item for your nav menu add the following (if your using bootstrap that is...)

```php
{!! $menu->using('bootstrap')->config()->devour() !!}
```

Other frameworks will be supported at a later time, the Materialize framework is being worked on right now.

## YOU DON'T HAVE MY FRAMEWORK HOW DARE YO-

##### Just stop right there... Build your own framework handler!

## How?

##### Just look below...

How can I build my own framework for this menu system? All you need to do is (somewhere) make a class that has the same methods as the class below.

```php
class MyFramework extends Kregel\Menu\Interfaces\AbstractMenu{
    public function bulidMenu($menu)
    {
		//
	}
    public function add(Array $options)
    {
		//
    }
    public function addDropdown($dropdown_name, $elements)
    {
		//
    }
    public function devour()
    {
		//
    }
    public function buildMenu($menu)
    {
		//
    }
    public function config()
    {
    	//
    }
}
```

## Okay... Now what...?

##### Well... Now you can customize this how you want. I would recommend looking at the default bootstrap handler, and if you have any questions send me an email! :)