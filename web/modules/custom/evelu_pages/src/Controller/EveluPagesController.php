<?php
/**
* @file
* Contains \Drupal\evelu_hello\Controller\EveluPagesController.
*/

namespace Drupal\evelu_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
* Controlador para devolver el contenido de las páginas definidas
*/
class EveluPagesController extends ControllerBase {
  public function simple() {
  //...
}

  public function calculator($num1, $num2) {
    //a) comprobamos que los valores facilitados sean numéricos
    //y si no es así, lanzamos una excepción
    if (!is_numeric($num1) || !is_numeric($num2)) {
      throw new BadRequestHttpException(t('No numeric arguments specified.'));
    }

    //b) Los resultados se mostrarán en formato lista HTML (ul).
    //Cada elemento de la lista se añade a un array
    $list[] = $this->t("@num1 + @num2 = @sum",
                        array('@num1' => $num1,
                              '@num2' => $num2,
                              '@sum' => $num1 + $num2));
    $list[] = $this->t("@num1 - @num2 = @difference",
                        array('@num1' => $num1,
                              '@num2' => $num2,
                              '@difference' => $num1 - $num2));
    $list[] = $this->t("@num1 x @num2 = @product",
                        array('@num1' => $num1,
                              '@num2' => $num2,
                              '@product' => $num1 * $num2));

    //c) Evitar error de división por cero
    if ($num2 != 0)
      $list[] = $this->t("@num1 / @num2 = @division",
                          array('@num1' => $num1,
                                '@num2' => $num2,
                                '@division' => $num1 / $num2));
    else
      $list[] = $this->t("@num1 / @num2 = undefined (division by zero)", array('@num1' => $num1, '@num2' => $num2));

    //d) Se transforma el array $list en una lista HTML (ul)
    $output['forcontu_pages_calculator'] = array(
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Operations:'),
    );

    //e) Se devuelve el array renderizable con la salida.
    return $output;
  }
} //cierre de class
