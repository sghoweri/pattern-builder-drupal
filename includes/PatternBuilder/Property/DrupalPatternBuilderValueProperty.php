<?php

/**
 * @file
 * Class to contain component objects without a schema.
 *
 * File is not namespaced in order to work with D7 class loading.
 */

use PatternBuilder\Property\PropertyInterface;
use PatternBuilder\Property\PropertyAbstract;

/**
 * Class to contain generic value data without a schema.
 */
class DrupalPatternBuilderValueProperty extends PropertyAbstract implements PropertyInterface {
  protected $data;

  /**
   * Constructor for the component.
   */
  public function __construct() {
    $this->initProperties();
  }

  /**
   * {@inheritdoc}
   */
  public function initProperties() {
    $this->data = new \stdClass();
  }

  /**
   * {@inheritdoc}
   */
  public function get($name = NULL) {
    if (!isset($name)) {
      return $this->data;
    }
    return isset($this->data->{$name}) ? $this->data->{$name} : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function set($name, $value) {
    $this->data->{$name} = $value;
  }

  /**
   * Set data with an associative array.
   *
   * @param array $items
   *   An array of values with keys of property names.
   */
  public function setByAssoc(array $items) {
    foreach ($items as $name => $value) {
      $this->set($name, $value);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $rendered = new \stdClass();
    foreach ($this->data as $k => $value) {
      if (is_object($value) && method_exists($value, 'render')) {
        $rendered->{$k} = $value->render();
      }
      else {
        $rendered->{$k} = $value;
      }
    }

    return $rendered;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRender() {
    return $this->data;
  }

}
