<?php

/**
 * @file
 * Utility functions.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Element after build handler; suppress element if nothing presented.
 */
function _basic_ingest_suppress_if_no_options(array $element, FormStateInterface $form_state) {
  $element['#access'] = !empty($element['#options']);
  return $element;
}
