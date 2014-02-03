<?php defined('SYSPATH') or die('No direct script access.');

class Resources_Controller extends Main_Controller {

  const INDEX_PAGE = 'index.php/resource';
  var $logged_in;

  public function __construct() {
    parent::__construct();
    $this->template->this_page = 'resources';
    // Is the Admin Logged In?
    $this->logged_in = Auth::instance()->logged_in();
    //$this->session = Session::instance();

  }

  public function index() {
    // If user has access, redirect to adminview or memberview
    /*
    if ($this->auth->has_permission("admin_ui")) {
      url::redirect(url::site().'admin/resources');
    }
    if ($this->auth->has_permission("member_ui")){
      url::redirect(url::site().'members/resources');
    }
    */
    if ($this->session->get('user_message')) {

    }
    $resources = ORM::factory('material')->find_all();
    //$topics = ORM::factory('topic')->find_all();
    $this->template->header->this_page = 'resources';
    $this->template->content = new View('index');
    $this->template->content->resources = $resources;
    //$this->template->content->topics = $topics;
  }

  //loads the view with the commentssection below
  public function view($material_id = 0) {
    $this->template->header->this_page = 'resources';
    $db = new Database();

    $this->template->content = new View('resources/view');
    $material = new Material_Model();
    $category = new Category_Model();
    $talk = new Talk_Model();
    $talk->description = '';
    $form = array(
      'nickname' => '',
      'email' => '',
      'description' => ''
    );
    $errors = $form;
    $form_error = FALSE;
    $material = ORM::factory('material', $material_id);
    $category = ORM::factory('category', $material->category_id);
    foreach ($material->talks as $talk_m) {
      $talkarray[] = $talk_m->id;
    }
    $this->template->content->logged_in = $this->logged_in;
    $this->template->content->form = $form;
    $this->template->content->form_error = $form_error;
    $this->template->content->material = $material;
    $this->template->content->category = $category;
    if ($_POST) {
      $post = array_merge($_POST);
      if (resources::validate_comments($post)) { //passing validation
        $talk->material_id = $material->id;
        $talk->nickname = $_POST['nickname'];
        $talk->email = $_POST['email'];
        $talk->description = $_POST['description'];
        $talk->create_date = date("y-m-d H:i:s");
        $talk->save();
        url::redirect(url::site() . 'resources/view/' . $material->id);
      }
      else {
        // Repopulate the form fields
        $form = arr::overwrite($form, $post->as_array());

        // Populate the error fields, if any
        $errors = arr::merge($errors, $post->errors('talk'));
        $form_error = TRUE;
        $this->template->content->form_error = $form_error;
        $this->template->content->errors = $errors;
      }
    }
  }
}