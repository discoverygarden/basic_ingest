<?php

namespace Drupal\basic_ingest\Form\Ajax;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\NestedArray;

class FieldModelToMedia {

  const FORM_COORDS = ['field_model', 'widget'];
  const VALUE_COORDS = ['field_model', 0, 'target_id'];
  const NAME = 'field_model';
  const REDIRECT = 'redirect_to_media';
  const REDIRECT_ID = self::REDIRECT;

  public static function alter(array &$form, FormStateInterface $form_state) {
    $form['#submit'][] = [static::class, 'submit'];
    static::dump($form['#submit'], 'qewr');

    $form[static::REDIRECT] = [
      '#type' => 'checkbox',
      '#title' => t('Redirect to media ingest.'),
      '#default_value' => $form_state->getValue(static::REDIRECT, TRUE),
      '#weight' => 100,
    ];
  }

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

  protected static function getMapped(FormStateInterface $form_state) {
    $id = $form_state->getValue(static::VALUE_COORDS);
    static::dump($id, 'id');

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

  protected static function dump($value, $qwer = '') {
    \Drupal::service('logger.factory')->get('asdf')->debug('{tag}: {value}', [
      'tag' => $qwer,
      'value' => print_r($value, TRUE),
    ]);
  }

  public static function submit(array &$form, FormStateInterface $form_state) {
    static::dump('in our submit...');
    if ($form_state->getValue(static::REDIRECT)) {
      $mapped = static::getMapped($form_state);

      static::dump($mapped, 'set redirect');
      $form_state->setRedirect('entity.media.add_page', [
        'media_type' => $mapped,
      ]);
    }
  }

}
