<?php

namespace Drupal\ib_task_93\Form;

use Drupal\Core\CoreServiceProvider;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure example settings for this site.
 */
class ConfigurationForm extends ConfigFormBase {

  /**
   * Drupal\Core\Cache\CacheBackendInterface definition.
   *
   * @var Drupal\Core\Cache\CacheBackendInterface
   */
  protected $drupalService;

  /**
   * {@inheritdoc}
   */
  public function __construct(CoreServiceProvider $drupal_service) {
    $this->drupalService = $drupal_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
    );
  }

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

    $taxonomy_country = [];

    $taxonomy_countries = $this->drupalService->getStorage("taxonomy_term")->loadTree('country');
    foreach ($taxonomy_countries as $variable) {
      $taxonomy_country[] = $variable->name;
    }

    $form['countries'] = [
      '#type' => 'select',
      '#options' => $taxonomy_country,
      '#title' => $this->t('Countries'),
      '#default_value' => $config->get('countries'),
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
      ->save();

    parent::submitForm($form, $form_state);

  }

}
