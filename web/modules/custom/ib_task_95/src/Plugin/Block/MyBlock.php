<?php

namespace Drupal\ib_task_95\Plugin\Block;

/**
* @file
* Contains \Drupal\test_twig\Controller\TestTwigController.
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
      '#type' => ' #test_var',
      '#markup' => 'This is Drupal 9 custom block',
      '#test_var' => 'hello world',
    ];
  }

}
