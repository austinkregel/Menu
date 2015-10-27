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

 3. Publish our config 
 ```php 
 php artisan vendor:publish --provider="Kregel\Menu\MenuServiceProvider"
 ```
 
 4. Which ever blade file is storing your current nav set up just add ONE line of code to replace your whole menu system and where ever you start your menu, just replace it with what's below.

```php
@include('menu::main.bootstrap')
```

Other frameworks will be supported at a later time, the Materialize framework is being worked on right now.

### Configuration
So, now you have your menu system set up, it's recommended that you edit your configuration. How? You might ask. There's so much and it's soooo confusing that I don't know where to begin!

Well... Let me help you out here.

###### Brand Name
There are quite a few things that you should really change. Something like the `brand.name`, should be changed to your brand's name. Whether that is your business's name, your product/projects name, or your name. You don't need to use [font-awesome](http://fortawesome.github.io/Font-Awesome)(but you totally should). 

###### Theme
I usually leave the theme alone; however, you can chagne it to what ever you want.

###### Items
The array within the "items" section is every element that will be located on every page whether logged in or logged out.

###### Login
This is enabled by default. Those elements located withing the "sign-in" section. These elements will be shown ONLY when the end user is NOT logged in.

Within the "sign-out" section, the default is actually a Dropdown menu. The title of it is "My Account", there is a divider header entitled "settings", then there is an element entitiled settings, the empty single quotes is a way for the default frameworks to differentiate between when to use the divider header and just a divider.

###### Custom Css Frameworks!
While it is described more below, the best way to access this is by just newing up your framework handler. That can be done by just making an anonymous function and having it return a new class.

## YOU DON'T HAVE MY FRAMEWORK HOW DARE YO-

##### Just stop right there... Build your own framework handler!

## How?

##### Just look below...

How can I build my own framework for this menu system? All you need to do is (somewhere) make a class that has the same methods as the class below.

```php
class MyFramework extends Kregel\Menu\Interfaces\AbstractMenu{
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
