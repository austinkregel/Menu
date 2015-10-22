<?php
namespace Kregel\Menu\Frameworks;
use Kregel\Menu\Interfaces\AbstractMenu;
class Bootstrap extends AbstractMenu{

    public $menu = '';

    public function add(Array $options)
    {
        $tmpmenu = '';
        // die(var_dump($options));
        foreach ($options as $inner_text => $linkIconArray) {
            if (is_array($linkIconArray) && !isset($linkIconArray['link']) && !isset($linkIconArray['icon'])) {
                $tmpmenu .= $this->addDropdown($inner_text, $linkIconArray, true);
            } elseif (is_object($linkIconArray)) {
                $tmpmenu .= $this->addDropdown($inner_text, (Array)$linkIconArray, true);
            } else {
                $tmpmenu .= $this->build($inner_text, $linkIconArray);
            }
        }
        return $tmpmenu;
    }

    public function addDropdown($dropdown_name, $elements, $submenu = false)
    {
        return '<li class="dropdown'.($submenu?' submenu':'').'">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$dropdown_name.' <span class="caret"></span></a>
          <ul class="dropdown-menu">
            '.$this->add($elements).'
          </ul>
        </li>';
        // Need to figure out.
    }

    public function config()
    {

    	$this->menu = '';
        $configArray = config('kregel.menu.items');
        
        $this->menu .= $this->add($configArray);
        
        return $this;
    }

    protected function buildMenu($menu)
    {
        return $this->buildBootstrap($menu);
    }

    protected function build($item_name, $menu, $attributes = [])
    {
        // die(var_dump($menu));
        if(!empty($menu['icon']))
            if(is_array($menu['icon'])){
                $icon = implode('', $menu['icon']);
            } else {
                $icon = $menu['icon'];
            }
        return '<li>
                <a '.$this->attributes(['href'=>$this->linkBuilder($menu['link']), $attributes]).'>
               '.(!empty($icon)?'<i '.$this->attributes(['class'=> $icon]).'></i>
                &nbsp;':'').$item_name.'
              </a>
            </li>
            ';
    }    
    /**
     * This returns the value of the menu.
     * @return String
     */
    public function devour(){
        return $this->menu;
    }
    public function mainMenu(){
    	return view('menu::main.bootstrap');
    }
}