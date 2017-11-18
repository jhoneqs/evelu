<?php
/**
* @file
* Contains \Drupal\evelu_pages\Controller\EveluPagesController.
*/

namespace Drupal\evelu_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Drupal\user\UserInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
* Controlador para devolver el contenido de las páginas definidas
*/
class EveluPagesController extends ControllerBase {

  public function simple() {
    return array(
      '#markup' => '<p>' . $this->t('This is a simple page (with no arguments)') . '</p>',
      );
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
    $output['evelu_pages_calculator'] = array(
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Operations:'),
    );

    //e) Se devuelve el array renderizable con la salida.
    return $output;
  } //cierre de class

  public function user(UserInterface $user) {
    $list[] = $this->t("Username: @username",
              array('@username' => $user->getAccountName()));
    $list[] = $this->t("Email: @email",
              array('@email' => $user->getEmail()));
    $list[] = $this->t("Roles: @roles",
              array('@roles' => implode(', ', $user->getRoles())));
    $list[] = $this->t("Last accessed time: @lastaccess",
              array('@lastaccess' => \Drupal::service('date.formatter')->format($user->getLastAccessedTime(), 'short')));

    $output['evelu_pages_user'] = array(
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('User data:'),
    );
    return $output;
  }

  public function links() {
    //link to /admin/structure/blocks
    $url1 = Url::fromRoute('block.admin_display');
    $link1 = Link::fromTextAndUrl(t('Go to the Block administration page'), $url1);
    $url3 = Url::fromRoute('<front>');
    $link3 = Link::fromTextAndUrl(t('Go to Front page'), $url3);
    $url4 = Url::fromRoute('entity.node.canonical', ['node' => 1]);
    $link4 = Link::fromTextAndUrl(t('Link to node/1'), $url4);
    $url5 = Url::fromRoute('entity.node.edit_form', ['node' => 1]);
    $link5 = Link::fromTextAndUrl(t('Link to edit node/1'), $url5);
    $url6 = Url::fromUri('https://www.forcontu.com');
    $link6 = Link::fromTextAndUrl(t('Link to www.forcontu.com'), $url6);
    $url7 = Url::fromUri('internal:/core/themes/bartik/css/layout.css');
    $link7 = Link::fromTextAndUrl(t('Link to layout.css'), $url7);
    $url8 = Url::fromUri('https://www.drupal.org');
    $link_options = array(
      'attributes' => array(
        'class' => array(
          'external-link',
          'list'
        ),
        'target' => '_blank',
        'title' => 'Go to drupal.org',
      ),
    );
    $url8->setOptions($link_options);
    $link8 = Link::fromTextAndUrl(t('Link to drupal.org'), $url8);

    $list[] = $link1;
    $list[] = $this->t('This text contains a link to %enlace. Just convert it to String to use it into a text.',['%enlace' => $link1->toString()]);
    $list[] = $link3;
    $list[] = $link4;
    $list[] = $link5;
    $list[] = $link6;
    $list[] = $link7;
    $list[] = $link8;

    $output['evelu_pages_links'] = array(
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Examples of links:'),
    );
    return $output;
  }
}
