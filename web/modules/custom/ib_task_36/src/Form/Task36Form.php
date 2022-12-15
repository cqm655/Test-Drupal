<?php

namespace Drupal\ib_task_36\Form;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\CssCommand;

/**
 * Class Task36Form, that creates a form.
 */
class Task36Form extends FormBase {

  /**
   * Drupal\Core\Messenger definition.
   *
   * @var Drupal\Core\Messenger
   */
  protected $messenger;

  /**
   * {@inheritdoc}
   */
  public function __construct(MessengerInterface $messengerInterface) {
    $this->messenger = $messengerInterface;
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
   * {@inheritdoc}
   */
  public function getFormId() {

    return 'ib_task_36_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Number'),
      '#placeholder' => $this->t('+375...'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validatePhoneAjax',
        'event' => 'keyup',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Verifying phone..'),
        ],
      ],
         // Element in wich will be shown result if needed.
         '#suffix' => '<div class="phone-validation"></div>'
    ];

    $form['phone_number_prefix'] = [
      '#suffix' => '<div class="phone-validation-prefix"></div>'
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
  public function validatePhoneAjax(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    $number = $form_state->getValue('phone_number');
    // Values to compare with country code.
    $number_prefix = substr($number, 0, 4);
    // Get Operator code.
    $extract_operator_code = substr($number,4,2);

    $operator_codes = [
      '25',
      '33',
      '44',
    ];

    // Check number prefix to match country code.
    if (!(($number_prefix) == '+375') || !(preg_match('/^[0-9+]{14}+$/', $number))  || !in_array($extract_operator_code, $operator_codes)) {
      $response->addCommand(new HtmlCommand('.phone-validation-prefix', 'Incorrect number format'));
    }
    else {

      $response->addCommand(new HtmlCommand('.phone-validation-prefix', ''));

    } 

    return $response;
 }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
