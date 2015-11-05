<?php

namespace Kregel\Menu;

use Closure;

class Menu
{
    // $menu->use('bootstrap')->add()->add()->add()->devour()
    public $framework;

    public $menu = '';
    /**
     * This will tell the menu builder to use a spessific css
     * framework, check if what's defined as the $css_framework
     * if the config value is set then use this $css_framework over
     * the config value.
     *
     * @param String $css_framework
     *
     * @return This this
     */
    public function using($css_framework)
    {
        $this->framework = strtolower($css_framework);
        switch ($this->framework) {
            case 'bootstrap':
                return new Frameworks\Bootstrap();
            case 'materilize':
                return new Frameworks\Materialize();
            default:
                /** @var Closure $customClass */
                $customClass = config('kregel.menu.custom-css-framework');

                return $customClass($this);
        }
    }
}
