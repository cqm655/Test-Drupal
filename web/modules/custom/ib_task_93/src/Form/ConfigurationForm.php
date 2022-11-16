<?php

namespace Drupal\ib_task_93\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class ConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {

    return 'ib_task_92_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ib_tassk_93s.content',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ib_tassk_93s.content');

    $form['countries'] = [
      '#type' => 'select',
      '#options' => ['Moldova', 'Belarus', 'Urkaine', 'Russia'],
      '#title' => $this->t('Countries'),
      '#default_value' => $config->get('countries'),
    ];

    $form['show_country'] = [
      '#weight' => 100,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->config('ib_tassk_93s.content')
      // Set the submitted configuration setting.
      ->set('countries', $form_state->getValue('countries'))
      ->set('show_country', $form_state->getValue('countries'))
      ->save();

    parent::submitForm($form, $form_state);

  }

}
