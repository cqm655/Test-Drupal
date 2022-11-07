<?php

namespace Drupal\ib_task_82\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class ShowPageController.
 */
class ShowPageController extends ControllerBase {

  /**
   * Functon to return string.
   */
  public function index() {

    return [
      '#markup' => $this->t('Hello World !'),
    ];
  }

}
