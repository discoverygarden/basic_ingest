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

/**
 * Helper to load media usage descriptions.
 *
 * @return string[]
 *   Pairing of media use labels with descriptions from the taxonomy.
 */
function basic_ingest_get_media_usage_descriptions() {
  $uses = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('islandora_media_use');
  $descriptions = [];
  foreach ($uses as $use) {
    $descriptions[$use->name] = $use->description__value;
  }
  return $descriptions;
}
