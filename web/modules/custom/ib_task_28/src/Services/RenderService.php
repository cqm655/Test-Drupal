<?php

namespace Drupal\ib_task_28\Services;

/**
 * Class RenderService.
 *
 * @package Drupal\ib_task_28\Services
 */
class RenderService {

  /**
   * Function serving as a Alias for \Drupal::service.
   */
  public function serviceAlias() {

    $render = \Drupal::service('plugin.manager.block');

    return $render;
  }

}
