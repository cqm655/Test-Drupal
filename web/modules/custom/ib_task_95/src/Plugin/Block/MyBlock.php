<?php

namespace Drupal\ib_task_95\Plugin\Block;

/**
* @file
* Contains \Drupal\ib_task_95.
*/
use Drupal\Core\Block\BlockBase;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *    id = "MyBlock",
 *    admin_label = @Translation("Simple Text Block")
 *  )
 */
class MyBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'myTheme',
      '#test_var' => 'hello world',
    ];
  }

}
