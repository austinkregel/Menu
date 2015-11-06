<?php

namespace Kregel\Menu\Interfaces;

use Closure;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;

/**
 * This class will provide all functionallity
 * needed to build a menu to extend this system.
 */
abstract class AbstractMenu
{
    public $menu;

    /**
     * This function is for syntax sugar, it should call several
     * other function such as buildFRAMEWORKNAME($menu).
     *
     * @param Array $options Should be some kind of array/key pair
     */
    abstract public function add(Array $options);

    /**
     * This function will be used when you try to build an element
     * and this element needs to be some kind of dropdown.
     *
     * @param String $dropdown_name This will be name the name of the dropdown
     * @param Array $elements This will be an array of arrays, foreach
     *                              Element in the array it will make a link
     *                              icon and name.
     *
     * @example 'Some Dropdown' => [
     *        'Dropdown Item' => [
     *            '/some-link', 'fa fa-check'
     *        ]
     *        // or a dropdown within a dropdown.
     *        'Sub-dropdown' => [
     *            [
     *                'Dropdown Item' => [
     *                    '/some-link', 'fa fa-check'
     *                ]
     *            ]
     *        ]
     * ]
     */
    abstract public function addDropdown($dropdown_name, $elements);

    /**
     * Offer user the option of using the configuration file
     * to build the whole menu using the desired framework.
     *
     * @return [type] [description]
     */
    abstract public function config();

    /**
     * Builds the entire HTML / DOM for the menu.
     *
     * @return HTML / DOM
     */
    abstract public function devour();

    /**
     * This should be called within the add function to ensure
     * that the menu will be built the way it should be.
     *
     * @param String $menu A string full of HTML
     *
     * @return This $this
     */
    abstract protected function buildMenu($menu);


    /**
     * @param $link
     * @return string
     */
    protected function linkBuilder($link)
    {
        if (is_array($link)) {
            list($route, $params) = $link;
            return $this->generateLink($route, $params);
        } else {
            return $this->generateLink($link, null);
        }
    }

    /**
     * This will generate a url relating to the given route, whether that is
     * from a raw url or if it is a route. It will also grab the params for
     * the values.
     *
     * @param String $route
     * @param mixed $params
     * @return string
     */
    protected function generateLink($route, $params = null)
    {
        if ($route instanceof Closure) {
            $route = $this->stringify($route);
        }
        if (\Route::has($route)) {
            // If params is empty, just don't call it...
            if (empty($params))
                return route($this->routify($route));
            else // Since $params isn't empty and $route is a Route, just paramify both.
                return route($this->routify($route), $this->routeparamify($params));
        }
        if (empty($params))
            return url($this->routify($route));
        else // Since $params isn't empty and $route is not Route, just paramify both anyway.
            return url($this->routify($route), $this->routeparamify($params));
    }

    /**
     * This function will evaluate the value of the param $string
     * @param $string
     * @param bool|false $return_array
     * @return null|string|array
     */
    public function stringify($string, $return_array = false)
    {
        // Makes sure that it's not empty and it's not a 0, 1, 2 etc...
        if (empty($string) && !is_numeric($string))
            return null;
        // If the string is actually a closure, execute the closure and return it.
        elseif ($string instanceof Closure)
            // Run $this->stringify because we don't know what it returns and we want to be sure it's a string. or array
            return $this->stringify($this->run($string), $return_array);
        // Check if $string is an array.
        elseif (is_array($string)) {
            // As long as $return_array is true return the array, $string.
            if ($return_array)
                return $string;
            // If $return array is false, join all $string parts with a '-'
            return implode('-', $string);
        } elseif (is_object($string))
            // If $string is an object check if it has a __toString function, if it does return that.
            if (method_exists($string, '__toString'))
                return $string->__toString();// this will return the is_array() version of the object,
            // If $string is an object cast it to an array and re-run this function.
            else
                return $this->stringify((array)$string, $return_array);
        // converting it to an array then to a string imploding with '-'. #recursion
        elseif (is_numeric($string))
            return (string)$string;
        // As long as it's a string just return the $string variable.
        elseif (is_string($string))
            return $string;

        // What ever the hell you put in... We don't support it :P ... Sorry, maybe try casting it or implementing a
        // __toString() method.
        throw new UnexpectedTypeException("We don't know what type your variable is!", 'Anything but that');// Not exactly helpful...
    }
    // Pronounced r-out-ify

    /**
     * This is a dependancy injection function which allows the config
     * function to have new classes without needing them to have a need
     * for actually newing up the new objects.
     *
     * @param Callback $callback
     *
     * @return the results of the callback.
     */
    private function run($callback)
    {
        $injects = [];
        $reflectionFunction = new \ReflectionFunction($callback);
        foreach ($reflectionFunction->getParameters() as $parameter) {
            if ($class = $parameter->getClass()) {
                $injects[] = app($class->name);
            }
        }

        return call_user_func_array($callback, $injects);
    }

    /**
     * @param $route
     * @return string
     */
    public function routify($route)
    {
        return $this->stringify($route);
    }

    /**
     * @param $params
     * @return string|array
     */
    public function routeparamify($params)
    {
        return $this->stringify($params, true);
    }

    /**
     * This function is made to convert the array of attributes
     * to the desired html element array for ease of building
     * raw html / dom objects.
     *
     * @param Array $attr Key/ value pair for building the menu
     *
     * @return HTML/DOM raw html
     */
    protected function attributes(Array $attr)
    {
        $attr_string = '';
        foreach ($attr as $name => $value) {
            if (!empty($name) && !empty($value)) {
                if (is_array($value)) {
                    $attr_string .= ' ' . $name . '="' . implode(' ', $value) . '"';
                } else {
                    $attr_string .= ' ' . $name . '="' . $value . '"';
                }
            }
        }

        return $attr_string;
    }

}
