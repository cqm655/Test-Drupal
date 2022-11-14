<?php

namespace Drupal\ib_task_30\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\node\Plugin\views\filter\Access;
use Drupal\Tests\system\Functional\System\AccessDeniedTest;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class CheckUserRoleController.
 */
class CheckUserRoleController extends ControllerBase {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * Drupal\Component\Datetime\TimeInterface definition.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $dateTime;

  /**
   * {@inheritdoc}
   */
  public function __construct(AccountProxy $current_user, TimeInterface $date_time) {
    $this->currentUser = $current_user;
    $this->dateTime = $date_time;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
      $container->get('datetime.time'),
    );
  }

  /**
   * Functon to return string.
   */
  public function checkUserRole() {

    $user_roles = $this->currentUser->getRoles();

    $current_time = $this->dateTime->getCurrentTime();

    $current_minutes = floor($current_time / 60);

    if (in_array('administrator', $user_roles) && $current_minutes % 2 == 0) {

    }

    elseif (in_array('content_editor', $user_roles) && $current_minutes % 2 != 0 && $this->currentUser()->isAuthenticated()) {

    }

    else {
      $throwAccesError = new AccessDeniedHttpException();
      throw new $throwAccesError();
    }

    return [
      '#markup' => 'ok',
    ];
  }

}
