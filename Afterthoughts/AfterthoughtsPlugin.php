<?php
/**
 * Afterthoughts
 * 
 * @copyright St. Edwards University Library 2013
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * Afterthoughts
 * 
 * @package Omeka\Plugins\Afterthoughts
 */
 
class AfterthoughtsPlugin extends Omeka_Plugin_AbstractPlugin
{
    //Define Filters
    protected $_filters = array(
        'admin_navigation_main');
    
    //Add the Afterthoughts navigation link.
    public function filterAdminNavigationMain($nav)
    {
        $nav[] = array('label' => __('Afterthoughts'), 'uri' => url('afterthoughts'));
        return $nav;
    }
    
}
?>