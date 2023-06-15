<?php
session_start();

class Router
{
    private $_controller;
    private $_view;
    private $_db;

    public function __construct() {
        require_once ('models/databaseModel.php');
        $this->_db = new Database();
        $this->_db->initDatabase();
    }

    public function routeReq() {
        try {
            //if the request is a POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                //if the user signup
                if ($_SERVER['REQUEST_URI'] === '/signUp') {
                    require_once ('controllers/controllerSignup.php');
                    $this->_controller = new Signup($_POST);
                }
                else if ($_SERVER['REQUEST_URI'] === '/login'){
                    require_once ('controllers/controllerLogin.php');
                    $this->_controller = new Login($_POST);
                }
                else if ($_SERVER['REQUEST_URI'] === '/modifyUser'){
                    require_once ('controllers/controllerModifyUser.php');
                    $request_body = file_get_contents('php://input');
                    $data = json_decode($request_body);
                    $this->_controller = new ModifyUser($data);
                }
                else if ($_SERVER['REQUEST_URI'] === '/postPicture'){
                    require_once ('controllers/controllerPostPicture.php');
                    $image = $_FILES['image'];
                    $this->_controller = new PostPicture($image, $_POST);
                }
                else if ($_SERVER['REQUEST_URI'] === '/likePicture'){
                    require_once ('controllers/controllerLikePicture.php');
                    $this->_controller = new LikePicture($_POST);
                }
                else if ($_SERVER['REQUEST_URI'] === '/confirmPassword'){
                    require_once ('controllers/controllerConfirmPassword.php');
                    $this->_controller = new ConfirmPassword($_POST);
                }
            }
            //if the request is a GET
            else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                $url = '';
                //if the user request a specific route
                if (isset($_SERVER['REQUEST_URI'])) {
                    // echo ('REQUEST_URI');
                    $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
                    $ctrl = ucfirst(strtolower($url[0]));
                    $ctrlClass = "controller".$ctrl;
                    $ctrlFile = "controllers/".$ctrlClass.".php";
                //if the route exists
                    if (file_exists($ctrlFile)) {
                        // echo($url);
                        require_once ($ctrlFile);
                        $this->_controller = new $ctrl($url);
                    }
                //if not...
                    else {
                        echo ($ctrl);
                        require_once ('controllers/controllerIndex.php');
                        $this->_controller = new Index($url);
                    }
                }
                //if not...
                else {
                    require_once ('controllers/controllerIndex.php');
                    $this->_controller = new Index($url);
                }
            }
        }
        catch(Exception $e) {
            $errorMsg = $e->getMessage();
        }
    }
}

