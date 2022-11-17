<?php

namespace Drupal\ib_task_93\Form;

use Drupal\node\Entity\Node;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\Value;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure example settings for this site.
 */
class ConfigurationForm extends ConfigFormBase {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
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

    // $config - used to save choosen option from $form.
    $config = $this->config('ib_tassk_93s.content');

    $taxonomy_country = [];

    $taxonomy_countries = $this->entityTypeManager->getStorage("taxonomy_term")->loadTree('country');
    foreach ($taxonomy_countries as $country) {

      $taxonomy_country[$country->tid] = $country->name;
    }

    $form['country'] = [
      '#type' => 'select',
      '#options' => $taxonomy_country,
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('ib_tassk_93s.content')
    // Set the submitted configuration setting.
      ->set('country', $form_state->getValue('country'))
      ->save();

    parent::submitForm($form, $form_state);

  }

}
