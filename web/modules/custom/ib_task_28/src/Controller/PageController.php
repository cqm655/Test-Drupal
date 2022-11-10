<?php

namespace Drupal\ib_task_28\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class ShowPageController.
 */
class PageController extends ControllerBase {

  /**
   * Functon to return data.
   *
   * @param int $arg
   *   Url argument.
   */
  public function index($arg) {

    /**
     * {@inheritdoc}
     */
    function build() {
      return [
        '#markup' => ' block ',
      ];
    }

    $new_block = [];

    $i = 0;

    while ($i++ < $arg) {
      array_push($new_block, build());
    }

    return [
      $new_block,
    ];
  }

}
