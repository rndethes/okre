<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('active_link')) {
function menu_active($controller)
    {
        $ci = get_instance();

        $class = $ci->router->fetch_class();

        // print_r($controller);
        // exit();

        return ($class == $controller) ? 'active' : '';
    }
function menu_active_user($method)
    {
        $ci = get_instance();

        $class = $ci->router->fetch_method();

        // print_r($method);
        // exit();

        return ($class == $method) ? 'active' : '';
    }


    function createMenuSpaceTeam($iduser){
        $CI = &get_instance();
        $CI->load->model('Space_model');
         // Perhitungan denda 
        $teamSpace   = $CI->Space_model->dataSpaceTeam($iduser);

        return $teamSpace;
    }
}