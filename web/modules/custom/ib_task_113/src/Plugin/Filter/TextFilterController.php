<?php

namespace Drupal\ib_task_113\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class that provides a text filter.
 *
 * @Filter(
 *   id = "text_filter",
 *   title = @Translation("Autocapitalize Preconfigured Words"),
 *   description = @Translation("Autocapitalizes preconfigured words anywhere they occur in the filtered text"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class TextFilterController extends FilterBase {

  /**
   * Provides a processed text render element.
   */
  public function process($text, $langcode) {
    // Words that user add.
    $words_to_capitalize = $this->settings['words_to_capitalize'];
    // Filter user input from settings.
    $array_of_text = explode('separator', str_replace([',', '.', ' ', '/', '!'], 'separator', strtolower($words_to_capitalize)));

    $new_text = str_replace($array_of_text, array_map('ucfirst', $array_of_text), $text);

    return new FilterProcessResult($new_text);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['words_to_capitalize'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Add words to the filter. '),
      '#default_value' => $this->settings['words_to_capitalize'],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Add',
    ];
    return $form;
  }

}
