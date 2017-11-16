<?php
/**
* @file
* Contains \Drupal\evelu_hello\Controller\EveluHelloController.
*/

namespace Drupal\evelu_hello\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
* Controlador para devolver el contenido de las páginas definidas
*/
class EveluHelloController extends ControllerBase {

  public function hello() {
      return array(
          '#markup' => '<p>' . $this->t('Hello, Evelu! This is my first module in Drupal 8!') . '</p>',
    );
  }
}
