<?php

namespace Kregel\Menu\Frameworks;

use Auth;
use Kregel\Menu\Interfaces\AbstractMenu;

class Materialize extends AbstractMenu
{
    public $menu = '';
    public $dropdowns = '';
    private $menuCount = 0;
    public function add(Array $options)
    {
        $tmpmenu = '';
        // die(var_dump($options));
        foreach ($options as $inner_text => $linkIconArray) {
            if (is_array($linkIconArray) && !isset($linkIconArray['link']) && !isset($linkIconArray['icon'])) {
                $tmpmenu .= $this->addDropdown($inner_text, $linkIconArray, ['submenu']);
            } elseif (is_object($linkIconArray)) {
                $tmpmenu .= $this->addDropdown($inner_text, (Array) $linkIconArray, ['submenu']);
            } else {
                $tmpmenu .= $this->build($inner_text, $linkIconArray);
            }
        }

        return $tmpmenu;
    }

    public function addDropdown($dropdown_name, $elements, $classes = [])
    {
        ++$this->menuCount;
        $this->dropdowns .= '<ul class="dropdown-content" id="dropdown-'.$this->menuCount.'">
            '.$this->add($elements).'
        </ul>';

        return '<li class="'.implode(' ', $classes).'">
            <a href="#" class="dropdown-button" data-activates="dropdown-'.$this->menuCount.'" role="button" aria-haspopup="true" aria-expanded="false">'.$dropdown_name.' <i class="material-icons right">arrow_drop_down</i></a>
        </li>';
    }

    public function config()
    {
        $this->menu = '';
        $this->menu .= $this->add(config('kregel.menu.items'));
        if (config('kregel.menu.login.enabled')) {
            if (Auth::check()) {
                $this->menu .= $this->add(config('kregel.menu.login.sign-out'));
            } else {
                $this->menu .= $this->add(config('kregel.menu.login.sign-in'));
            }
        }

        return $this;
    }

    protected function buildMenu($menu)
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
            return '<li class="divider"></li>';
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
     * @return String
     */
    public function devour()
    {
        return $this->menu;
    }
}
