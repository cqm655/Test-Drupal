<?php

namespace Drupal\ib_task_94\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *    id = "ib_task_94_Block",
 *    admin_label = @Translation("Simple Text Block")
 *  )
 */
class SimpleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $items = [];

    return [
      '#items' => $items,
      '#theme' => 'block_template',
      '#var_block' => $items,
      '#attached' => [
        'library' => ['ib_task_94/ib_task_94'],
      ]
    ];
  }

}
