<?php

namespace Drupal\ib_task_122\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class PageExampleController.
 */
class PageExampleController extends ControllerBase {

  /**
   * Function showIndex to return output.
   */
  public function showIndex() {

    return [
      '#markup' => 'Event triggered',
    ];
  }

}
