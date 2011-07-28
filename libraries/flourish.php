<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

final class Flourish
{
    private $igniter;
    private $ci_f_path;
    
    public $flourish_path;
    
    
    public function __construct()
    {
        $this->igniter = &get_instance();
        
        $this->ci_f_path     = realpath(dirname(__FILE__) . '/../');
        $this->flourish_path = "{$this->ci_f_path}/libraries/flourish";
        
        spl_autoload_register(array(&$this, 'load'));
        
        $this->igniter->load->helper('fDatabase');
    }
    
    public function model($class, $table='', $database='')
    {
        $path = '';
        
        if (($last_slash = strrpos($class, '/')) !== false) {
            $path  = rtrim(substr($class, 0, ($last_slash+1)), '/'.DIRECTORY_SEPARATOR);
            $class = substr($class, ($last_slash+1));
        }
        
        $file_path = "{$this->ci_f_path}/models/{$path}/".strtolower($class).EXT;
        
        if (!file_exists($file_path)) {
            show_error('Unable to locate the model you have specified: '.$class);
        }
        
        require_once($file_path);
        
        if ($table) {
            fORM::mapClassToTable($class, $table);
        }
        
        if ($database) {
            fORM::mapClassToDatabase($class, $database);
        }
    }
    
    public function load($class)
    {
        foreach (func_get_args() as $class) {
            if ($class[0] == 'f') {
                $file_path = "{$this->flourish_path}/{$class}".EXT;
                
                if (file_exists($file_path)) {
                    require_once($file_path);
                }
            }
        }
    }
}

/* End of file flourish.php */
/* Location: ./application/third_party/ci-f/libraries/flourish.php */