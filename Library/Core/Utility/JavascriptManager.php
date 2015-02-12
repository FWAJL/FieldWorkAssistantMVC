<?php

/**
 *
 * @package     Basic MVC framework
 * @author      Jeremie Litzler
 * @copyright   Copyright (c) 2015
 * @license		
 * @link		
 * @since		
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * JavascriptManager Class
 *
 * @package       Library
 * @subpackage    Core\Utility
 * @category      JavascriptManager
 * @author        Jeremie Litzler
 * @link		
 */

namespace Library\Core\Utility;

if (!defined('__EXECUTION_ACCESS_RESTRICTION__'))
  exit('No direct script access allowed');

class JavascriptManager extends \Library\ApplicationComponent {

  /**
   *
   * @var array $files Javascript files list
   */
  protected $files = array();

  public function __construct(\Library\Application $app) {
    parent::__construct($app);
    $this->files = \Library\Core\DirectoryManager::GetFilesNamesRecursively(
            __ROOT__ . \Library\Enums\ApplicationFolderName::WebJs, "js");
  }

}
