<?php

namespace Drupal\ib_task_56\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *    id = "Ib_task_56_Block",
 *    admin_label = @Translation("Task_56_Modal_Window")
 *  )
 */
class ModalShowBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    // Array to set link attributes.
    $options = [
      'attributes' => ['class' => ['use-ajax'], 'data-dialog-type' => ['modal']],
    ];
    // Get the current path.
    $current_path = Url::fromRoute('<current>', [], ['absolute' => 'true'])->toString();

    $internal_link = Link::fromTextAndUrl($this->t('modalOpenLink'), Url::fromUri($current_path, $options))->toString();

    return [
      '#theme' => 'block-template',
      '#variable' => $internal_link,
      '#attached' => [
        'library' => ['ib_task_56/ib_task_56'],
      ]
    ];
  }

}
