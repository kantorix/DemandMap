<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Resources helper class.
 *
 * @package     Resources
 * @author     #OSJUBA
 * @copyright  (c) 2008 Ushahidi Team
 * @license     http://www.ushahidi.com/license.html
 */
class resources_Core {
  /**
   * Validation of form fields
   *
   * @param array $post Values to be validated
   */
  public static function validate_materials(array & $post) {

    // Exception handling
    if (!isset($post) OR !is_array($post)) {
      return FALSE;
    }

    // Create validation object
    $post = Validation::factory($post)
      ->pre_filter('trim', TRUE)
      ->add_rules('title', 'required', 'length[3,255]')
      ->add_rules('content', 'required')
      ->add_rules('category_id', 'required')
      ->add_rules('link', 'valid::url');

    /*//XXX: Hack to validate for no checkboxes checked
    if ( ! isset($post->incident_category))
    {
      $post->incident_category = "";
      $post->add_error('incident_category','required');
    }
    else
    {
      $post->add_rules('incident_category.*','required','numeric');
    }*/

    // Return
    return $post->validate();
  }

  /**
   * Validation of form fields
   *
   * @param array $post Values to be validated
   */
  public static function validate_comments(array & $post) {

    // Exception handling
    if (!isset($post) OR !is_array($post)) {
      return FALSE;
    }

    // Create validation object
    $post = Validation::factory($post)
      ->pre_filter('trim', TRUE)
      ->add_rules('nickname', 'required', 'length[3,255]')
      ->add_rules('email', 'required', 'valid::email', 'valid::email_domain')
      ->add_rules('description', 'required');

    /*//XXX: Hack to validate for no checkboxes checked
    if ( ! isset($post->incident_category))
    {
      $post->incident_category = "";
      $post->add_error('incident_category','required');
    }
    else
    {
      $post->add_rules('incident_category.*','required','numeric');
    }*/

    // Return
    return $post->validate();
  }
}
	