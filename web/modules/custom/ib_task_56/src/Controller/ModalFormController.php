<?php

namespace Drupal\ib_task_56\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class ModalFormController.
 */
class ModalFormController extends ControllerBase {

  /**
   * Functon to out some data.
   */
  public function modalShow() {

    // Array to set link attributes.
    $options = [
      'attributes' => ['class' => ['use-ajax'], 'data-dialog-type' => ['modal']],
    ];
    $internal_link = Link::fromTextAndUrl($this->t('modalOpenLink'), Url::fromUri('http://test.loc/show-modal', $options))->toString();

    // Connection to js.
    $output['#attached']['library'][] = 'ib_task_56/ib_task_56';
    return [
      '#markup' => $internal_link,
    ];
  }

}
