<?php

namespace Kregel\Menu\Frameworks;

use Auth;
use Kregel\Menu\Interfaces\AbstractMenu;

class Bootstrap extends AbstractMenu
{
    public $menu = '';
    public $dropdowns = '';
    public $menuCount = 0;

    public function add($options)
    {
        $tmpmenu = '';

        foreach ($options as $inner_text => $linkIconArray) {
            if (is_array($linkIconArray) && !isset($linkIconArray['link']) && !isset($linkIconArray['icon'])) {
                $tmpmenu .= $this->addDropdown($inner_text, $linkIconArray, ['submenu']);
            } elseif (is_object($linkIconArray) && !is_callable($linkIconArray)) {
                $tmpmenu .= $this->addDropdown($inner_text, (array) $linkIconArray, ['submenu']);
            } elseif ($linkIconArray instanceof \Closure) {
                $tmpmenu .= $this->add($linkIconArray());
            } else {
                $tmpmenu .= $this->build($inner_text, $linkIconArray);
            }
        }

        return $tmpmenu;
    }

    public function addDropdown($dropdown_name, $elements, $classes = [])
    {
        return '<li class="dropdown '.implode(' ', $classes).'">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$dropdown_name.' <span class="caret"></span></a>
          <ul class="dropdown-menu">
            '.$this->add($elements).'
          </ul>
        </li>';
    }

    public function config()
    {
        $this->menu = '';
        $this->menu .= $this->add(config('kregel.menu.items'));
//        dd(config('kregel.menu.login.sign-out'));
        if (config('kregel.menu.login.enabled')) {
            if (Auth::check()) {
                $this->menu .= $this->add(config('kregel.menu.login.sign-out'));
            } else {
                $this->menu .= $this->add(config('kregel.menu.login.sign-in'));
            }
        }

        return $this;
    }

    public function buildMenu($menu)
    {
        $this->menu = $this->add($menu);

        return $this;
    }

    protected function build($item_name, $menu, $attributes = [])
    {
        // die(var_dump($menu));
        if (!empty($menu['icon'])) {
            if (is_array($menu['icon'])) {
                $icon = implode('', $menu['icon']);
            } else {
                $icon = $menu['icon'];
            }
        }
        if (!is_array($menu)) {
            if (empty($item_name)) {
                return '<li class="dropdown-header">'.$menu.'</li>';
            } else {
                return '<li class="divider"></li>';
            }
        }

        return '<li>
                <a '.$this->attributes(['href' => $this->linkBuilder($menu['link']), $attributes]).'>
               '.(!empty($icon) ? '<i '.$this->attributes(['class' => $icon]).'></i>
                &nbsp;' : '').$item_name.'
              </a>
            </li>
        ';
    }

    /**
     * This returns the value of the menu.
     *
     * @return string
     */
    public function devour()
    {
        return $this->menu;
    }
}
