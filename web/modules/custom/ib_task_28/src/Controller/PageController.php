<?php

namespace Drupal\ib_task_28\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\ib_task_28\Services\RenderService;

/**
 * Class PageController.
 */
class PageController extends ControllerBase {

  /**
   * Function index, receive arg from URL, return arg number of blocks.
   */
  public function index($arg) {

    $object_Services_Render = new RenderService();

    $block_manager = $object_Services_Render->serviceAlias();
    // You can hard code configuration or you load from settings.
    $config = [];

    $blocks_to_dysplay = [];

    $i = 0;

    while ($i++ < $arg) {

      $plugin_block = $block_manager->createInstance('ib_task_28_Block', $config);
      $render = $plugin_block->build();
      $blocks_to_dysplay[] = $render;
    };
    return [
      $blocks_to_dysplay,
    ];
  }

}
