<?php
namespace Kregel\Menu\Interfaces;
abstract class AbstractMenu{
    public $menu;
    public $framework;
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
     * This will tell the menu builder to use a spessific css
     * framework, check if what's defined as the $css_framework
     * if the config value is set then use this $css_framework over
     * the config value.
     * @param  String $css_framework 
     * @return This this
     */
    abstract public function using($css_framework);

    /**
     * Offer user the option of using the configuration file
     * to build the whole menu using the desired framework
     * @return [type] [description]
     */
    abstract public function config();
    /**
     * This function is made to convert the array of attributes
     * to the desired html element array for ease of building 
     * raw html / dom objects.
     * @param  Array  $attr Key/ value pair for building the menu
     * @return HTML/DOM     raw html
     */
    abstract protected function attributes(Array $attr);
    /**
     * Builds the entire HTML / DOM for the menu
     * @return HTML / DOM
     */
    abstract public function devour();
}