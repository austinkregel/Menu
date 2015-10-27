<?php
namespace Kregel\Menu\Interfaces;
use Closure;
/**
 * This class will provide all functionallity 
 * needed to build a menu to extend this system.
 */
abstract class AbstractMenu{
    public $menu;
	/**
     * This should be called within the add function to ensure
     * that the menu will be built the way it should be.
     * @param  String $menu A string full of HTML
     * @return This $this
     */
    abstract protected function buildMenu($menu);

    /**
     * This function is for syntax sugar, it should call several
     * other function such as buildFRAMEWORKNAME($menu). 
     * @param Array $options Should be some kind of array/key pair
     */
    abstract public function add(Array $options);

    /**
     * This function will be used when you try to build an element
     * and this element needs to be some kind of dropdown.
     * @param String $dropdown_name This will be name the name of the dropdown
     * @param Array $elements       This will be an array of arrays, foreach 
     *                              Element in the array it will make a link
     *                              icon and name.
     * @example 'Some Dropdown' => [
     * 		'Dropdown Item' => [
     * 			'/some-link', 'fa fa-check'
     * 		]
     * 		// or a dropdown within a dropdown.
     * 		'Sub-dropdown' => [
     * 			[
     * 				'Dropdown Item' => [
     * 					'/some-link', 'fa fa-check'
     * 				]
     * 			]
     * 		]
     * ]
     */
    abstract public function addDropdown($dropdown_name, $elements);

    /**
     * Offer user the option of using the configuration file
     * to build the whole menu using the desired framework
     * @return [type] [description]
     */
    abstract public function config();

    /**
     * Builds the entire HTML / DOM for the menu
     * @return HTML / DOM
     */
    abstract public function devour();
    
    /**
     * This should be the base that joins your menu with the base menu. - depreciated.
     * @return 
     */
    // abstract public function mainMenu();
    /**
     * This will build the link
     * @param  A link object.
     * @return [type]       [description]
     */
    protected function linkBuilder($link)
    {

        if(is_array($link)){
            list($route, $params) = $link;
            if(\Route::has($route)){
                if($params instanceof Closure){
                    $link = route($route, $this->run($params));
                }elseif(is_array($params)){
                    $link = route($route, $params);
                }else{
                    $link = route($route, $params());
                }   
            } else {
                if($params instanceof Closure)
                    $link = url($route, $this->run($params));
                else
                    $link = url($route, $params);
            }
        } else {
            if(\Route::has($link))
                $link = route($link);
            else
                $link = url($link);
        }
        return $link;
    }

    /**
     * This is a dependancy injection function which allows the config
     * function to have new classes without needing them to have a need
     * for actually newing up the new objects.
     * @param  Callback $callback 
     * @return the results of the callback.
     */
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
    /**
     * This function is made to convert the array of attributes
     * to the desired html element array for ease of building 
     * raw html / dom objects.
     * @param  Array  $attr Key/ value pair for building the menu
     * @return HTML/DOM     raw html
     */
    protected function attributes(Array $attr)
    {
        $attr_string = '';
        foreach ($attr as $name => $value) {
            if(!empty($name) && !empty($value))
                if (is_array($value)) {
                    $attr_string .= ' '.$name.'="'.implode(' ', $value).'"';
                } else {
                    $attr_string .= ' '.$name.'="'.$value.'"';
                }
        }
        return $attr_string;
    }
}
