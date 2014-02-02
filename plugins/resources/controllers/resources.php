<?php defined('SYSPATH') or die('No direct script access.');

class Resources_Controller extends Main_Controller {

  const INDEX_PAGE = 'index.php/resource';

  public function __construct() {
    parent::__construct();
    $this->session = Session::instance();
  }

  public function index() {
    if ($this->session->get('user_message')) {

    }
    $resources = ORM::factory('material')->find_all();
    $topics = ORM::factory('topic')->find_all();
    $this->template->header->this_page = 'resources';
    $this->template->content = new View('resources/index');
    $this->template->content->resources = $resources;
    $this->template->content->topics = $topics;
  }

  // loads the new resource form
  public function submit() {
    $this->template->header->this_page = 'resources';
    $db = new Database();
    $this->template->content = new View('resources/edit');
    $material = new Material_Model();
    $topic = new Topic_Model();
    $topics = ORM::factory('topic')->find_all();
    $referencearray = array();
    $this->template->content->topic = $topic;
    $this->template->content->topics = $topics;
    $this->template->content->material = $material;
    $this->template->content->referencearray = $referencearray;
  }

  // edit the resource
  public function edit($material_id = 0) {
    $this->template->header->this_page = 'resources';
    $db = new Database();
    $this->template->content = new View('resources/edit');
    $material = new Material_Model();
    $topic = new Topic_Model();
    $material = ORM::factory('material', $material_id);
    $topics = ORM::factory('topic')->find_all();
    $referencearray = array();
    foreach ($material->topics as $reference) {
      $referencearray[] = $reference->id;
    }
    $this->template->content->material = $material;
    $this->template->content->topic = $topic;
    $this->template->content->topics = $topics;
    $this->template->content->referencearray = $referencearray;
  }

  public function upload($id = 0) {
    $this->template->content = new View('resources/upload');
    $this->template->content->material_id = $id;

  }


  public function getfile($material_id = 0) {
    $full_name = time() . "_" . $_FILES['uploadFile'] ['name'];
    move_uploaded_file($_FILES['uploadFile'] ['tmp_name'],
      DOCROOT . "media/uploads/{$full_name}");
    //$this->template->content = new View('resources/getfile');
    $db = new Database();
    $file = new File_Model();
    //$tmp = $_FILES['uploadFile'] ['name'];
    $file->material_id = $material_id;
    $file->filetitle = $_FILES['uploadFile'] ['name'];
    $file->filename = $full_name;
    $file->create_date = date("y-m-d H:i:s");
    $file->save();
    $this->session->set_flash('user_message', 'Hello, how are you?');
    url::redirect(url::site() . 'resources');
  }

  // delete the resource
  public function delete($material_id = 0) {
    $db = new Database();
    $material = new Material_Model();
    $material = ORM::factory('material', $material_id);
    //delete all corresponding topics
    foreach ($material->topics as $reference) {
      $material->remove(ORM::factory('topic', $reference->id));
    }
    foreach ($material->talks as $talk) {
      $talk->delete();
    }
    foreach ($material->files as $file) {
      $file->delete();
    }
    $material->save(); //needed
    $material->delete();
    url::redirect(url::site() . 'resources');
  }

  // save the resource
  public function post($id = 0) {
    $db = new Database();
    $material = new Material_Model();
    $material_id = $id;
    $material = ORM::factory('material', $material_id);
    if ($_POST) {
      $material->title = $_POST['title'];
      $material->content = $_POST['content'];
      //delete all corresponding topics
      foreach ($material->topics as $reference) {
        $material->remove(ORM::factory('topic', $reference->id));
      }
      //save selected topics
      if (isset($_POST['topics'])) {
        foreach ($_POST['topics'] as $selected_topic) {
          $material->add(ORM::factory('topic', $selected_topic));
        }
      }

      $material->save();
      //var_dump(count($material->topics()));
      url::redirect(url::site() . 'resources');
    }
    else {

    }
  }

  //loads the view with the commentssection below
  public function view($material_id = 0) {
    $this->template->header->this_page = 'resources';
    $db = new Database();
    $this->template->content = new View('resources/view');
    $material = new Material_Model();
    $talk = new Talk_Model();
    $material = ORM::factory('material', $material_id);
    foreach ($material->talks as $talk) {
      $talkarray[] = $talk->id;
    }
    $this->template->content->material = $material;
    if ($_POST) {
      $talk->material_id = $material->id;
      $talk->nickname = $_POST['nickname'];
      $talk->email = $_POST['email'];
      $talk->description = $_POST['comment'];
      $talk->create_date = date("y-m-d H:i:s");
      $talk->save();
      url::redirect(url::site() . 'resources/view/' . $material->id);
    }
    else {

    }
  }


}