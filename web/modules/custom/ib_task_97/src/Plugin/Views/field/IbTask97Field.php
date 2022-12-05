<?php

namespace Drupal\ib_task_97\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\Core\Url;

/**
 * A handler that provides a custom field with node data.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("counter_views_field")
 */
class IbTask97Field extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function usesGroupBy() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Do nothing -- to override the parent query.
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['hide_alter_empty'] = ['default' => FALSE];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $url = Url::fromRoute('ib_task_97.content', ['node_id' => $values->nid]);
    $result = [
      '#markup' => $this->t('<a href="@link" class="use-ajax">Count</a>', ['@link' => $url->toString()]),
    ];
    return $result;
  }

}
