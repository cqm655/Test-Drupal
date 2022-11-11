<?php

namespace Drupal\ib_task_28\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *    id = "ib_task_28_Block",
 *    admin_label = @Translation("Simple Text Block")
 *  )
 */
class SimpleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'block_template',
      '#var_block' => 'my block',
    ];
  }

}
