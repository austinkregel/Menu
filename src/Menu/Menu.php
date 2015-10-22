<?php

namespace Kregel\Menu;

use Closure;
use Auth;
use Kregel\Menu\Interfaces\AbstractMenu;
class Menu extends AbstractMenu
{
    // $menu->use('bootstrap')->add()->add()->add()->devour()
    public $framework;
    
    public $menu = '';

    public function using($css_framework)
    {
        $this->framework = strtolower($css_framework);
        return $this;
    }
    public function add(Array $options)
    {
        $tmpmenu = '';
        // die(var_dump($options));
        foreach ($options as $inner_text => $linkIconArray) {
            if (is_array($linkIconArray) && !isset($linkIconArray['link']) && !isset($linkIconArray['icon'])) {
                $tmpmenu .= $this->addDropdown($inner_text, $linkIconArray);
            } elseif (is_object($linkIconArray)) {
                $tmpmenu .= $this->addDropdown($inner_text, (Array)$linkIconArray);
            } else {
                $tmpmenu .= $this->{'build'.ucfirst($this->framework)}($inner_text, $linkIconArray);
            }
        }
        return $tmpmenu;
    }

    public function addDropdown($dropdown_name, $elements)
    {
        return '<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            '.$this->add($elements).'
          </ul>
        </li>';
        // Need to figure out.
    }

    public function config()
    {
        $configArray = config('kregel.menu.items');
        
        $this->menu .= $this->add($configArray);
        
        return $this;
    }
    protected function buildMenu($menu)
    {
        switch ($this->framework) {
            case 'bootstrap':
                return $this->buildBootstrap($menu);
            case 'materilize':
                return $this->buildBootstrap($menu);
            default:
                $customMenuCss = config('kregel.menu.custom-css-framework');
                // Inject $this, so its accessable elsewhere? Probably bad practice...
                return $customMenuCss($this, $menu);
        }
    }
    protected function build()
    {

    }

    protected function buildBootstrap($item_name, $menu)
    {
        // die(var_dump($menu));
        if(is_array($menu['icon'])){
            $icon = implode('', $menu['icon']);
        } else {
            $icon = $menu['icon'];
        }
        return '<li>
                <a '.$this->attributes(['href'=>$this->linkBuilder($menu['link']), 'role' => 'tab']).'>
                <i '.$this->attributes(['class'=> $icon]).'></i>
                &nbsp;
                '.$item_name.'
              </a>
            </li>
            ';
    }

    protected function attributes(Array $attr)
    {
        $attr_string = '';
        foreach ($attr as $name => $value) {
            if (is_array($value)) {
                $attr_string .= ' '.$name.'="'.implode(' ', $value).'"';
            } else {
                $attr_string .= ' '.$name.'="'.$value.'"';
            }
        }
        return $attr_string;
    }
    protected function linkBuilder($link){
        if(is_array($link)){
            list($route, $params) = $link;
            if($params instanceof Closure)
                $link = route($route, $this->run($params));
            else
                $link = route($route, $params);
        }else
            $link = route($link);
        return $link;
    }

    public function devour(){
        return $this->menu;
    }
    private function run($callback)
    {
        $injects = [];
        $reflectionFunction = new \ReflectionFunction($callback);
        $someValue = [];
        foreach ($reflectionFunction->getParameters() as $parameter) {
            if ($class = $parameter->getClass())
            {
                $injects[] = app($class->name);
            }
        }
        return call_user_func_array($callback,  $injects);
    }

}
