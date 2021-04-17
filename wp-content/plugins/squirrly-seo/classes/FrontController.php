<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * The main class for controllers
 *
 */
class SQ_Classes_FrontController {

    /** @var object of the model class */
    public $model;

    /** @var boolean */
    public $flush = true;

    /** @var name of the  class */
    private $name;

    public function __construct() {
        // Load error class
        SQ_Classes_ObjController::getClass('SQ_Classes_Error');

        /* get the name of the current class */
        $this->name = get_class($this);

        /* load the model and hooks here for wordpress actions to take efect */
        /* create the model and view instances */
        $model_classname = str_replace('Controllers', 'Models', $this->name);
        if (SQ_Classes_ObjController::getClassPath($model_classname)) {
            $this->model = SQ_Classes_ObjController::getClass($model_classname);
        }

        //IMPORTANT TO LOAD HOOKS HERE
        /* check if there is a hook defined in the controller clients class */
        SQ_Classes_ObjController::getClass('SQ_Classes_HookController')->setHooks($this);

        /* Load the Submit Actions Handler */
        SQ_Classes_ObjController::getClass('SQ_Classes_ActionController');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController');

        // load the abstract classes
        SQ_Classes_ObjController::getClass('SQ_Models_Abstract_Domain');
        SQ_Classes_ObjController::getClass('SQ_Models_Abstract_Models');
        SQ_Classes_ObjController::getClass('SQ_Models_Abstract_Seo');
    }

    public function getClass() {
        return $this->name;
    }

    /**
     * load sequence of classes
     * Function called usualy when the controller is loaded in WP
     *
     * @return mixed
     */
    public function init() {
        $class = SQ_Classes_ObjController::getClassPath($this->name);

        if (!$this->flush) {
            return $this->getView($class['name']);
        }

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia($class['name']);
        echo $this->getView($class['name']);

    }

    /**
     * Get the block view
     *
     * @param  string $view Class name
     * @return mixed
     */
    public function getView($view) {
        return SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->getView($view, $this);
    }

    /**
     * Called as menu callback to show the block
     *
     */
    public function show() {
        $this->flush = true;

        echo $this->init();
    }

    /**
     * initialize settings
     * Called from index
     *
     * @return void
     */
    public function runAdmin() {
        // load the remote controller in admin
        SQ_Classes_ObjController::getClass('SQ_Classes_RemoteController');
        SQ_Classes_ObjController::getClass('SQ_Models_Abstract_Assistant');

        // show the admin menu and post actions
        SQ_Classes_ObjController::getClass('SQ_Controllers_Menu');
        SQ_Classes_ObjController::getClass('SQ_Models_RoleManager');

    }

    /**
     * Run fron frontend
     */
    public function runFrontend() {
        //Load Frontend only if Squirrly SEO is enabled
        SQ_Classes_ObjController::getClass('SQ_Controllers_Frontend');

        /* show the topbar admin menu and post actions */
        SQ_Classes_ObjController::getClass('SQ_Controllers_Snippet');

        /* call the API for save posts */
        SQ_Classes_ObjController::getClass('SQ_Controllers_Api');

    }

    /**
     * first function call for any class
     *
     */
    protected function action() { }

    /**
     * This function will load the media in the header for each class
     *
     * @return void
     */
    public function hookHead() { }

    /**
     * Show the notification bar
     */
    public function getNotificationBar(){
        echo $this->getView('Blocks/VersionBar');
    }
}
