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
    $selected_category_ids = array();
    $categories = new Category_Model();
    $categories = ORM::factory('category')->find_all();
    $resources = ORM::factory('material')->find_all();
    //$topics = ORM::factory('topic')->find_all();
    $this->template->header->this_page = 'resources';
    $this->template->content = new View('index');
    $this->template->content->selected_category_ids = $selected_category_ids = array();;
    $this->template->content->resources = $resources;
    $this->template->content->categories = $categories;
    //$this->template->content->topics = $topics;
  }

  public function filter() {
    $db = new Database();
    $this->template->content = new View('index');
    $selected_category_ids = array();
    if (isset($_POST['categories'])) {
      $selected_category_ids = $_POST['categories'];
      $resources = ORM::factory('material')
        ->in('category_id', $_POST['categories'])->find_all();
    }
    else {
      $resources = ORM::factory('material')->find_all();
    }
    //$topics = ORM::factory('topic')->find_all();
    $categories = new Category_Model();
    $categories = ORM::factory('category')->find_all();

    $this->template->content->selected_category_ids = $selected_category_ids;
    $this->template->content->resources = $resources;
    $this->template->content->categories = $categories;
    //$this->template->content->topics = $topics;
  }

  // loads the new resource form
  public function submit() {
    $db = new Database();
    $form = array(
      'title' => '',
      'content' => '',
      'category_id' => '',
      'link' => 'http://www.google.com',
      'nickname' => '',
      'email' => ''
    );
    $this->template->content = new View('resources/edit');
    $material = new Material_Model();
    $categories = new Category_Model();
    $categories = ORM::factory('category')->find_all();
    $categories_list = array();
    $form_error = FALSE;
    foreach ($categories as $category) {
      $categories_list[$category->id] = $category->category_title;
    }
    /*
    $topic = new Topic_Model();
    $topics = ORM::factory('topic')->find_all();
    $referencearray = array();
    $this->template->content->topic = $topic;
    $this->template->content->topics = $topics;
    $this->template->content->referencearray = $referencearray;
    */
    $this->template->content->material = $material;
    $this->template->content->form = $form;
    $this->template->content->form_error = $form_error;
    $this->template->content->category = $category;
    $this->template->content->categories_list = $categories_list;
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

  // save the resource
  public function post($material_id = 0, $saved = FALSE) {
    $db = new Database();
    $form = array(
      'title' => $_POST['title'],
      'content' => $_POST['content'],
      'category_id' => $_POST['category_id'],
      'link' => $_POST['link'],
      'nickname' => $_POST['nickname'],
      'email' => $_POST['email']
    );
    $this->template->content = new View('resources/edit');
    // Copy the form as errors, so the errors will be stored with keys corresponding to the form field names
    $errors = $form;
    $form_error = FALSE;
    $form_saved = ($saved == 'saved');
    $material = new Material_Model();
    $material = ORM::factory('material', $material_id);
    $categories = new Category_Model();
    $categories = ORM::factory('category')->find_all();
    $categories_list = array();
    foreach ($categories as $category) {
      $categories_list[$category->id] = $category->category_title;
    }
    $this->template->content->form = $form;
    $this->template->content->errors = $errors;
    $this->template->content->form_error = $form_error;
    $this->template->content->material = $material;
    $this->template->content->categories_list = $categories_list;
    if ($_POST) {
      // Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
      $post = array_merge($_POST);
      if (resources::validate_materials($post)) { //passing validation
        $material->title = $_POST['title'];
        $material->content = $_POST['content'];
        $material->category_id = $_POST['category_id'];
        $material->link = $_POST['link'];
        $material->user_id = 0;
        $material->user_email = $_POST['email'];
        $material->user_nickname = $_POST['nickname'];
        $material->save();
        /*
        //delete all corresponding topics
        foreach ($material->topics as $reference){
          $material->remove(ORM::factory('topic', $reference->id));
        }
        //save selected topics
        if (isset($_POST['topics'])){
          foreach ($_POST['topics'] as $selected_topic){
            $material->add(ORM::factory('topic', $selected_topic));
          }
        }
        */
        url::redirect(url::site() . 'resources/thanks');
      } else {
        // Repopulate the form fields
        $form = arr::overwrite($form, $post->as_array());

        // Populate the error fields, if any
        $errors = arr::merge($errors, $post->errors('resource'));
        $form_error = TRUE;
        $this->template->content->form_error = $form_error;
        $this->template->content->errors = $errors;
      }
    }
  }

  /**
   * Resources Thanks Page
   */
  public function thanks() {
    $this->template->content = new View('resources/submit_thanks');
  }
}