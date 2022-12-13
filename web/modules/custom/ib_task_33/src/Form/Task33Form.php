<?php

namespace Drupal\ib_task_33\Form;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Class Task33Form, that creates a form.
 */
class Task33Form extends FormBase {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a logger_channel object.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * {@inheritdoc}
   */
  public function __construct(EntityTypeManager $entity_type_manager, LoggerChannelFactoryInterface $logger_factory) {
    $this->entityTypeManager = $entity_type_manager;
    $this->loggerFactory = $logger_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('logger.factory'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {

    return 'ib_task_33_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // // Array to store countries.
    $taxonomy_country = [];

    $taxonomy_countries = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree('task32_country');
    foreach ($taxonomy_countries as $country) {

      $taxonomy_country[$country->tid] = $country->name;
    }

    $form['country'] = [
      '#type' => 'select',
      '#title' => $this->t('Country'),
      '#options' => $taxonomy_country,
      '#ajax' => [
        'callback' => '::myAjaxCallback',
        // The wrapper actually is the id of the element that.
        'wrapper' => 'first',
      ],
    ];

    if($form_state->getValue('country')) {
      // Array to store cities.
      $taxonomy_city = [];
      // Get cities by reference entity.
      $taxonomy_cities = $this->entityTypeManager->getStorage('taxonomy_term')->loadByProperties(['field_relation_city_country' => $form_state->getValue('country')]);

      foreach ($taxonomy_cities as $city) {

        $taxonomy_city[$city->id()] = $city->getName();
      }
    }

    $form['city'] = [
      '#type' => 'select',
      '#title' => $this->t('City'),
      // The "wrapper" id that the ajax response will be injected into.
      // must have an id ="wrapper set on select 1 form'.
      '#prefix' => '<div id="first">',
      '#suffix' => '</div>',
      // For some reason you  need to set '#validated' => 'true' other wise tou get :.
      // An illegal choice has been detected. Please contact the site administrator.
      '#validated' => 'true',
      '#options' => $taxonomy_city,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit'
    ];
    return $form;
  }

  /**
   * Function to process ajaxRequest.
   */
  public function myAjaxCallback(array &$form, FormStateInterface $form_state) {
    return $form['city'];
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get value of selected option from form.
    $city_key = $form_state->getValue('city');
    $city_val = $form['city']['#options'][$city_key];
    // Get value of selected option from form.
    $country_key = $form_state->getValue('country');
    $country_val = $form['country']['#options'][$country_key];

    $this->loggerFactory->get('Task 33')->critical('City name is @city, and country name is @country', [
        '@city' => $city_val,
        '@country' => $country_val
       ]);
  }

}
