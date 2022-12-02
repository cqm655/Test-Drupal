<?php

namespace Drupal\ib_task_102\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;

/**
 * Class MultiStepForm that returns a multi step form in modal window.
 */
class MultiStepForm extends FormBase {

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
   * Variable to count form pages.
   *
   * @var step
   */
  protected $step = 1;

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'multi_step_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    if ($form_state->has('page_num') && $form_state->get('page_num') == 2) {
      // Return first submit from function.
      return $this->firstSubmit($form, $form_state);
    }
    if ($form_state->has('page_num') && $form_state->get('page_num') == 3) {
      // Return the second submit from function.
      return $this->secondSubmit($form, $form_state);
    }

    // Add a wrapper div that will be used by the Form API to update the form using AJAX.
    $form['#prefix'] = '<div id="ajax_form_multistep_form">';
    $form['#suffix'] = '</div>';
    // Show first modal window.
    if ($this->step == 1) {
      $form['message-step'] = [
        '#markup' => '<div class="step">' . $this->t('Step 1 of 2') . '</div>',
      ];
      $form['message-title'] = [
        '#markup' => '<h2>' . $this->t('Enter Title') . '</h2>',
      ];
      $form['factory_title'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Factory Title'),
        '#placeholder' => $this->t('...enter Title'),
        '#required' => TRUE,
        '#default_value' => $form_state->getValue('factory_title', ''),
      ];
      $form['factory_body'] = [
        '#type' => 'textarea',
        '#title' => $this->t('Body'),
        '#placeholder' => $this->t('...body data'),
        '#required' => TRUE,
        '#default_value' => $form_state->getValue('factory_body', ''),
      ];

    }
    // Show the second modal window.
    if ($this->step == 2) {
      $form['message-step'] = [
        '#markup' => '<div class="step">' . $this->t('Step 2 of 2') . '</div>',
      ];
      $form['message-title'] = [
        '#markup' => '<h2>' . $this->t('Please enter your City and Country bellow:') . '</h2>',
      ];
      $form['factory_city'] = [
        '#type' => 'textfield',
        '#title' => $this->t('City'),
        '#placeholder' => $this->t('... enter City'),
        '#required' => TRUE,
      ];
      $form['factory_country'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Country'),
        '#placeholder' => $this->t('...enter Country'),
        '#required' => TRUE,
      ];
    }
    // Show the first modal window.
    if ($this->step == 3) {
      $form['message-step'] = [
        '#markup' => '<p class="complete">' . $this->t('- Complete -') . '</p>',
      ];
      $form['message-title'] = [
        '#markup' => '<h2>' . $this->t('Thank you') . '</h2>',
      ];

    }

    if ($this->step == 1) {
      $form['buttons']['forward'] = [
        '#type' => 'submit',
        '#submit' => ['::firstSubmit'],
        '#value' => $this->t('Next'),
        '#prefix' => '<div class="step1-button">',
        '#suffix' => '</div>',
        '#ajax' => [
          // We pass in the wrapper we created at the start of the form.
          'wrapper' => 'ajax_form_multistep_form',
          // We pass a callback function we will use later to render the form for the user.
          'callback' => '::ajaxFormMultistepFormAjaxCallback',
          'event' => 'click',
        ],
      ];
    }
    if ($this->step == 2) {
      $form['buttons']['forward'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
        '#ajax' => [
          // We pass in the wrapper we created at the start of the form.
          'wrapper' => 'ajax_form_multistep_form',
          // We pass a callback function we will use later to render the form for the user.
          'callback' => '::ajaxFormMultistepFormAjaxCallback',
          'event' => 'click',
        ],
      ];
    }

    $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    return $form;
  }

  /**
   * Function to save input data from first modal window and rebuild the form.
   */
  public function firstSubmit(array &$form, FormStateInterface $form_state) {
    $form_state
      ->set('page_values', [
        'factory_title' => $form_state->getValue('factory_title'),
        'factory_body' => $form_state->getValue('factory_body'),
      ]
      )
      ->set('page_num', $this->step++)
      ->setRebuild(TRUE);

  }

  /**
   * Function to save input data from second modal window and rebuild the form.
   */
  public function secondSubmit(array &$form, FormStateInterface $form_state) {
    $page_values = $form_state->get('page_values');

    $form_state
      ->set('page_values', [
        'factory_city' => $form_state->getValue('factory_city'),
        'factory_country' => $form_state->getValue('factory_country'),
        'factory_title' => $page_values['factory_title'],
        'factory_body' => $page_values['factory_body'],
      ]
       )
      ->set('page_num', $this->step++)
      ->setRebuild(TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    return parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->step++;
    $form_state->setRebuild();

    // Create a value page_value, to retreive saved data from input.
    $page_values = $form_state->get('page_values');
    // Creating a node of type Factory.
    $node = $this->entityTypeManager->getStorage('node')->create([
      'type'        => 'factory',
      'title'       => 'task_102',
      'field_factory_body' => $page_values['factory_body'],
      'field_factory_title' => $page_values['factory_title'],
      'field_factory_city' => $form_state->getValue('factory_city'),
      'field_factory_country' => $form_state->getValue('factory_country'),
    ]);
    $node->save();

  }

  /**
   * Function to return form to user.
   */
  public function ajaxFormMultistepFormAjaxCallback(array &$form, FormStateInterface $form_state) {

    return $form;
  }

}
