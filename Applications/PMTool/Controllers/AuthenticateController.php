<?php

/**
 *
 * @package		Basic MVC framework
 * @author		FWA DEV Team
 * @copyright	Copyright (c) 2014
 * @license
 * @link
 * @since
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Authenticate controller Class
 *
 * @package		Application/PMTool
 * @subpackage	Controllers
 * @category	AuthenticateController
 * @author		FWA Dev Team
 * @link
 */

namespace Applications\PMTool\Controllers;

if (!defined('__EXECUTION_ACCESS_RESTRICTION__'))
  exit('No direct script access allowed');

class AuthenticateController extends \Library\BaseController {

  /**
   * Method that loads the Login view.
   *
   * It loads the page title and the resources to load in the placeholders
   *
   * @param \Library\HttpRequest $rq: the request
   */
  public function executeLoadView(\Library\HttpRequest $rq) {
    //TODO: add resource using a Resource manager
    //$authenticate_js_script_path = "authenticate.js";
    $resourceFileKey = "login";

    $this->app->pageTitle = $this->app->i8n->getLocalResource($resourceFileKey, "page_title");
    $this->page->addVar('resx', $this->app->i8n->getLocalResourceArray($resourceFileKey));
  }

  /**
   * Method that receives the call from JS Client to login a user
   *
   * @param \Library\HttpRequest $rq: the request
   * @return json object A JSON object with the result bool value and success/error message
   */
  public function executeAuthenticate(\Library\HttpRequest $rq) {
    //Initialize the response to error.
    $result = $this->ManageResponseWS();

    //Let's retrieve the inputs from AJAX POST request
    $data_sent = $rq->post_ajax(NULL, FALSE);

    //Then, retrieve the login and password.
    $user = $this->PrepareUserObject($data_sent);

    //Load interface to query the database
    $manager = $this->managers->getManagerOf('Login');
    //Search for user in DB and return him
    $user_db = $manager->selectOne($user);
    
    
//    echo $user->password();
//    echo " ". $user_db[0]->password;
//    $this->IsPasswordCorrect($user->password(), $user_db[0]->password);
    //If user_db is null or not matching, set error message
    if (is_null($user_db) && !$this->IsPasswordCorrect($user->password(), $user_db[0]->password)) {
      //TODO: redirect after 3 sec
      header('Location: ' . __BASEURL__ . "login");
    } else {
      if (isset($data_sent["encrypt_pwd"])) {
        $this->EncryptUserPassword($manager, $user, $user_db);
      }
      //User is correct so log him in and set result to success
      $result = $this->ManageResponseWS("success");
    }

    header('Content-Type: application/json');
    echo json_encode($result, 128); //Encode response to pretty JSON
  }

  /**
   * Method that logout a user from the session and then redirect him to Login page.
   *
   * @param \Library\HttpRequest $rq
   */
  public function executeDisconnect(\Library\HttpRequest $rq) {
    $this->app->user->setAuthenticated(FALSE);
    header('Location: ' . __BASEURL__ . "login");
  }

  private function PrepareUserObject($data_sent) {
    $user = new \Library\BO\ProjectManager();
    $user->setPmEmail($data_sent["email"]);
    $user->setUserName($data_sent["username"]);
    $user->setPassword($data_sent["pwd"]);
    return $user;
  }
  /**
   * Method that logs in a user in the session.
   *
   */
  private function LoginUser() {
    $this->app->user->setAuthenticated();
  }
/**
 * 
 * @param DAL\BaseManager $manager
 * @param BO\ProjectManager $user_in
 * @param array(BO\ProjectManager) $user_db
 */
  private function EncryptUserPassword($manager, $user_in, $user_db) {
    $protect = new \Library\BL\Core\Encryption();
    $user_in->setPassword($protect->Encrypt($this->app->config->get("encryption_key"), $user_in->password()));
    $user_in->pm_id = $user_db[0]->pm_id;
    $manager->update($user_in);
  }
  /**
   * Check if the password is matching
   *
   * @param string $password_given
   * @param string $password_db
   * @return boolean
   */
  private function IsPasswordCorrect($password_given, $password_db) {
    $protect = new \Library\BL\Core\Encryption();
    echo $protect->Decrypt($this->app->config->get("encryption_key"), $password_db);
    return $password_given === $password_db;
  }

  /**
   * 
   * @param string $step
   * @return array
   */
  private function ManageResponseWS($step = "init") {
    $resourceFileKey = "login";
    if ($step === "success") {
      $this->LoginUser();
      return array(
        "result" => 1,
        "message" => $this->app->i8n->getLocalResource($resourceFileKey, "message_success")
      );
    } else {
      return array(
        "result" => 0,
        "message" => $this->app->i8n->getLocalResource($resourceFileKey, "message_error")
      );
    }
  }

}
