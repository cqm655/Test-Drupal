<?php

namespace Drupal\mypage\Controller\MyPageController;

/**
 * Class MyPageController.
 */
class MyPageController {

  /**
   * Functon to return string.
   */
  public function show() {
    return [
      '#markup' => 'A page to show some text',
    ];
  }

}
