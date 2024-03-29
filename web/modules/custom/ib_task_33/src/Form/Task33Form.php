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

    $form['country'] = [
      '#type' => 'select',
      '#title' => $this->t('Country'),
      '#options' => $this->getCountry(),
      '#ajax' => [
        'callback' => '::AjaxCallback',
        // The wrapper actually is the id of the element that.
        'wrapper' => 'city_div',
      ],
    ];
    $country_id = $form_state->getValue('country');
    $form['city'] = [
      '#type' => 'select',
      '#title' => $this->t('City'),
      // The "wrapper" id that the ajax response will be injected into.
      // must have an id ="wrapper set on select 1 form'.
      '#prefix' => '<div id="city_div">',
      '#suffix' => '</div>',
      // For some reason you  need to set '#validated' => 'true' other wise tou get :.
      // An illegal choice has been detected. Please contact the site administrator.
      '#validated' => 'true',
      '#options' => $this->getCity($country_id),
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
  public function AjaxCallback(array &$form, FormStateInterface $form_state) {
    return $form['city'];
  }

  /**
   * Function to return an array of Countries.
   */
  public function getCountry() {
    // Array to store countries.
    $countries = [];

    $term_countries = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree('task32_country');
    foreach ($term_countries as $country) {

      $countries[$country->tid] = $country->name;
    }
    return $countries;
  }

  /**
   * Function to return an array of Cities based on Country select form.
   */
  public function getCity($country_id) {
    // Array to store cities.
    $cities = [];

    if ($country_id) {
      // Get cities by reference entity.
      $term_cities = $this->entityTypeManager->getStorage('taxonomy_term')->loadByProperties(['field_relation_city_country' => $country_id]);

      foreach ($term_cities as $city) {

        $cities[$city->id()] = $city->getName();
      }
    }
      return $cities;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $country_id = $form_state->getValue('country');
    $city_id = $form_state->getValue('city');

    $city_name = $this->entityTypeManager->getStorage('taxonomy_term')->load($city_id);
    $country_name = $this->entityTypeManager->getStorage('taxonomy_term')->load($country_id);

    if (!empty($city_name) && !empty($country_name)) {
      $this->loggerFactory->get('Task 33')->critical('City name is @city, and country name is @country', [
        '@city' => $city_name->getName(),
        '@country' => $country_name->getName(),
      ]);
    }

  }

}
