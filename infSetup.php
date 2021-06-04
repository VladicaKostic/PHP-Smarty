<?php

require "infModel.php";
require 'libs/Smarty.class.php';

class InfModel_Smarty extends Smarty {
    function __construct() {
        parent::__construct();
        $this->setTemplateDir('templates');
        $this->setCompileDir('templates_c');
        $this->setConfigDir('configs');
        $this->setCacheDir('cache');
    }
}
