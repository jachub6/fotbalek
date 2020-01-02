<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

abstract class ZakladniController implements IController {

    protected $db;

    public function __construct() {
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
    }  
    abstract function show(string $pageTitle);
}
?>