<?php

namespace Drupal\ib_task_28\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\ib_task_28\Plugin\Block\Ib_task_28_Block;

/**
 * Class PageController.
 */
class PageController extends ControllerBase {

  /**
   * Function index, output data to view.
   *
   * @param int $arg
   *   $arg variable comming from URL.
   */
  public function index($arg) {

    return [
      '#markup' => $arg,
    ];
  }

}
