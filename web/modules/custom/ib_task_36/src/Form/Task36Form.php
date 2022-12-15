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

    // Check number prefix to match country code.
    if (!(preg_match('/[+](375)+(25|33|44|294|292|295|299){1}+[0-9]{7}+$/', $number))) {
      $response->addCommand(new HtmlCommand('.phone-validation', 'Incorrect number format'));
    }
    else {

      $response->addCommand(new HtmlCommand('.phone-validation', ''));

    }

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
