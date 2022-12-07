<?php

namespace Drupal\ib_task_32\Form;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Task32Form, that creates a form.
 */
class Task32Form extends FormBase {

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

    return 'ib_task_32_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Array to store countries.
    $taxonomy_country = [];
    // Array to store cities.
    $taxonomy_city = [];

    $taxonomy_countries = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree('task32_country');
    foreach ($taxonomy_countries as $country) {

      $taxonomy_country[$country->tid] = $country->name;
    }

    $form['country'] = [
      '#type' => 'select',
      '#options' => $taxonomy_country,
      '#title' => $this->t('Country'),
    ];

    $taxonomy_cities = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree('task32_city');
    foreach ($taxonomy_cities as $city) {

      $taxonomy_city[$city->tid] = $city->name;
    }

    $form['city'] = [
      '#type' => 'select',
      '#options' => $taxonomy_city,
      '#title' => $this->t('City'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
