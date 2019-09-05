<?php

namespace Drupal\basic_ingest\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\NestedArray;

/**
 * Helper; redirect to media ingest based on item model.
 */
class FieldModelToMedia {

  const FORM_COORDS = ['field_model', 'widget'];
  const VALUE_COORDS = ['field_model', 0, 'target_id'];
  const NAME = 'field_model';
  const REDIRECT = 'redirect_to_media';
  const REDIRECT_ID = self::REDIRECT;

  const NODE_COORDS = [
    'edit',
    'field_media_of',
    'widget',
    0,
    'target_id',
  ];
  const USE_COORDS = [
    'edit',
    'field_media_use',
    'widget',
  ];
  const ORIGINAL_FILE_URI = 'http://pcdm.org/use#OriginalFile';

  /**
   * Delegated for hook_form_alter().
   */
  public static function alter(array &$form, FormStateInterface $form_state) {
    $form['actions']['submit']['#submit'][] = [static::class, 'submit'];

    $form[static::REDIRECT] = [
      '#type' => 'checkbox',
      '#title' => t('Redirect to media ingest.'),
      '#description' => t('Redirect to the media ingest form for the default type of media after the ingest of this item. If there is no default media type, you will be redirected to the ingested item itself.'),
      '#default_value' => $form_state->getValue(static::REDIRECT, TRUE),
      '#weight' => 100,
    ];
  }

  /**
   * Map the URI/media type mapping into an actual mapping.
   *
   * @return string[]
   *   An associative array mapping URIs to media types which should be used
   *   by default for those types.
   */
  protected static function getMapping() {
    static $mapped = NULL;

    if ($mapped === NULL) {
      $mapped = [];
      foreach (\Drupal::config('basic_ingest.settings')->get('map') as $info) {
        assert(!isset($mapped[$info['uri']]), 'Multiple mappings.');
        $mapped[$info['uri']] = $info['media_type'];
      }
    }
    return $mapped;
  }

  /**
   * Get the media type for the selected model.
   *
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   The form state in which we're operating.
   *
   * @return string|null
   *   The media type ID to which the model's URI mapped; otherwise, NULL
   *   if there was no mapping.
   */
  protected static function getMapped(FormStateInterface $form_state) {
    $id = $form_state->getValue(static::VALUE_COORDS);

    if (!$id) {
      return NULL;
    }

    $term = \Drupal::service('entity_type.manager')
      ->getStorage('taxonomy_term')
      ->load($id);

    $value = $term ?
      $term->get('field_external_uri')->getValue() :
      NULL;
    $value = reset($value);

    $mapping = static::getMapping();

    return $value && isset($mapping[$value['uri']]) ?
      $mapping[$value['uri']] :
      NULL;
  }

  /**
   * Form submission handler.
   */
  public static function submit(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue(static::REDIRECT)) {
      $mapped = static::getMapped($form_state);

      $query_params = [];

      NestedArray::setValue(
        $query_params,
        static::NODE_COORDS,
        $form_state->getFormObject()->getEntity()->id()
      );

      $term_storage = \Drupal::service('entity_type.manager')->getStorage('taxonomy_term');
      $original_use_term_results = $term_storage->getQuery()
        ->condition('vid', 'islandora_media_use')
        ->condition('field_external_uri', static::ORIGINAL_FILE_URI)
        ->execute();

      if ($original_use_term_results) {
        NestedArray::setValue(
          $query_params,
          static::USE_COORDS,
          reset($original_use_term_results)
        );
      }

      $form_state->setRedirect('entity.media.add_form', [
        'media_type' => $mapped,
      ], [
        'query' => $query_params,
      ]);
    }
  }

}
