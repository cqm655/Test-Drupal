<?php

namespace Drupal\ib_task_93\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Implements a Simple Form API.
 */
class ModuleConfigurationForm extends FormBase {

  /**
   * Drupal\Core\Messenger\MessengerInterface definition.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messegeInterface;

  /**
   * {@inheritdoc}
   */
  public function __construct(MessengerInterface $messenger_interface) {
    $this->messegeInterface = $messenger_interface;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
            $container->get('messenger'),
        );
  }

  /**
   * The unique string identifying the form.
   *
   * @return string
   *   Return the unique id
   */
  public function getFormId() {

    return 'ib_task_93_id';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return 'simple.form.setting';
  }

  /**
   * Function to build Form.
   *
   * @param array $form
   *   Array to save data.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Object of type FormStateInterface.
   *
   * @return array
   *   Provide an array to save values.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Add description.
    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Select a country too add to header'),
    ];

    // Add select option.
    $form['countries'] = [
      '#type' => 'select',
      '#title' => $this->t('Country'),
      '#options' => ['Moldova', 'Armenia', 'Belarus', 'Russia', 'Ucraine'],
    ];

    // Add a submit button.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add'),
    ];

    return $form;
  }

  /**
   * Function to submit.
   *
   * @param array $form
   *   Provide an array to save values.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Provides an interface for an object containing the current state of a form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data = $this->messegeInterface;
    $key = $form_state->getValue('countries');
    $val = $form['countries']['#options'][$key];
    $data->addMessage('Country: ' . $val);

    // Redirect to same page.
    $form_state->setRedirect('ib_tassk_93s.content');
  }

}
