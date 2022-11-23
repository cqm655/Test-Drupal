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

    // Array of words to autocapitalize.
    $words_to_filter = ['statesman', 'notable', 'events', 'role', 'soon'];
    // Add words from settings.
    array_push($words_to_filter, $words_to_capitalize);
    // Remove html charachters.
    $trim_text = trim(preg_replace('/ + /', ' ', preg_replace('/[^A-Za-z ]/', ' ', urldecode(html_entity_decode(strip_tags($text))))));

    $array_of_text = explode(" ", $trim_text);
    // New array to store common words.
    $common_words_array = [];

    $common_words_array = array_intersect($array_of_text, $words_to_filter);
    // Array to capitalize first letter of $common_words_array.
    $text_ucfirst = [];

    $text_ucfirst = array_map('ucfirst', $common_words_array);

    $new_text = str_replace($common_words_array, $text_ucfirst, $text);

    return new FilterProcessResult($new_text);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['words_to_capitalize'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Add words to the filter'),
      '#default_value' => $this->settings['words_to_capitalize'],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Add',
    ];
    return $form;
  }

}
