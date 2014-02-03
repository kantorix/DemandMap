<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Resources Members Controller 
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   #OSJUBA <team@ushahidi.com> 
 * @package	   Ushahidi - http://source.ushahididev.com
 * @module	   Clickatell Controller	
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
*/

class Resources_Controller extends Members_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'resources';
	}
	
	function index(){
		$db = new Database();
		$material = new Material_Model();
		if (! $this->auth->has_permission("member_ui"))
		{
			
			//url::redirect(url::site().'resources');
		}
		if ($this->session->get('user_message')){
			
		}
		$resources = ORM::factory('material')->where('user_id', $this->user->id)->find_all();
		//$topics = ORM::factory('topic')->find_all();
        //$this->template->header->this_page = 'resources';
		$this->template->content = new View('members/index');
		$this->template->content->resources = $resources;
		//$this->template->content->topics = $topics;
	}
	
	// loads the new resource form
    public function submit() {
      $this->template->header->this_page = 'resources';
	    $db = new Database();	
		$form = array(
			'title' => '',
			'content' => '',
			'category_id' => '',
			'link' => 'http://www.google.com'
		);
		$this->template->content = new View('members/resources/edit');
        $material = new Material_Model();
		$categories = new Category_Model();
		$categories = ORM::factory('category')->find_all();
		$categories_list = array();
		$form_error = FALSE;
		foreach ($categories as $category){
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
	 public function view($material_id=0) {
		$db = new Database();
		
		$this->template->content = new View('members/resources/view');
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
		foreach ($material->talks as $talk)
		{
			$talkarray[] = $talk->id;
		}
		$this->template->content->form = $form;
		$this->template->content->form_error = $form_error;
		$this->template->content->material = $material; 
		$this->template->content->category = $category;		
		if ($_POST){
			$post = array_merge($_POST);
			if (resources::validate_comments($post)){ //passing validation
				$talk->material_id = $material->id;
				$talk->nickname = $_POST['nickname'];
				$talk->email = $_POST['email'];
				$talk->description = $_POST['description'];
				$talk->create_date = date("y-m-d H:i:s");
				$talk->save();		
				url::redirect(url::site().'members/resources/view/'.$material->id);
			}else{
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
	
	// edit the resource
    public function edit($material_id=0) {
        $db = new Database();
		$form_error = FALSE;
		$this->template->content = new View('members/resources/edit');
        $material = new Material_Model();
		$material = ORM::factory('material', $material_id);
		$form = array(
			'title' => $material->title,
			'content' => $material->content,
			'category_id' => $material->category_id,
			'link' => $material->link
		);
		$categories = new Category_Model();
		$categories = ORM::factory('category')->find_all();
		$categories_list = array();
		foreach ($categories as $category){
			$categories_list[$category->id] = $category->category_title;
		}
		
		//$topic = new Topic_Model();		
		//$topics = ORM::factory('topic')->find_all();
		/*$referencearray = array();
		foreach ($material->topics as $reference){
			$referencearray[] = $reference->id;
		}*/
		
		$this->template->content->form = $form;
		$this->template->content->form_error = $form_error;
		$this->template->content->material = $material;
		$this->template->content->category = $category;
		$this->template->content->categories_list = $categories_list;
		//$this->template->content->topic = $topic;
		//$this->template->content->topics = $topics;        
		//$this->template->content->referencearray = $referencearray;
    }
	
	// save the resource
    public function post($material_id=0, $saved = FALSE) {
        $db = new Database();
		$form = array(
			'title' => $_POST['title'],
			'content' => $_POST['content'],
			'category_id' => $_POST['category_id'],
			'link' => $_POST['link']
		);
		$this->template->content = new View('members/resources/edit');
		// Copy the form as errors, so the errors will be stored with keys corresponding to the form field names
		$errors = $form;
		$form_error = FALSE;
		$form_saved = ($saved == 'saved');			
        $material = new Material_Model();	
        $material = ORM::factory('material', $material_id);
		$categories = new Category_Model();
		$categories = ORM::factory('category')->find_all();
		$categories_list = array();
		foreach ($categories as $category){
			$categories_list[$category->id] = $category->category_title;
		}
		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->material = $material;
		$this->template->content->categories_list = $categories_list;
		if ($_POST){
			// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
			$post = array_merge($_POST);
			if (resources::validate_materials($post)){ //passing validation
				$material->title = $_POST['title'];
				$material->content = $_POST['content'];
				$material->category_id = $_POST['category_id'];
				$material->link = $_POST['link'];	
				$material->user_id = $this->user_id;				
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
				url::redirect(url::site().'members/resources/thanks');
			} else{
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
	
		// delete the resource
    public function delete($material_id=0) {
		$db = new Database();
        $material = new Material_Model();
		$material = ORM::factory('material', $material_id);
		
		/*
		//delete all corresponding topics
		foreach ($material->topics as $reference){
				$material->remove(ORM::factory('topic', $reference->id));
		}*/
		foreach ($material->talks as $talk){
				$talk->delete();
		}
		/*foreach ($material->files as $file){
				$file->delete();
		}*/
		$material->save();//needed
		$material->delete();	
		url::redirect(url::site().'resources');
    }
	
	/**
	 * Resources Thanks Page
	 */
	public function thanks(){
		$this->template->content = new View('members/resources/submit_thanks');
	}
}