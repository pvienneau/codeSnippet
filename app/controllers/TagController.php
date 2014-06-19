<?php 

/*
   Class: TagController
      Enter description here...

   Generated on Mon, 31 Aug 2009 20:00:28 -0400 by Framework.php

   Author:
      Philippe Archambault <philippe.archambault@gmail.com>
*/

class TagController extends Controller
{
	public function __construct()
	{
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn())
			redirect(get_url('login'));
		
	}

	public function index()
	{
		$this->setLayout('default');
		$this->display('tag/index', array(
			'tags' => Tag::all()
		));
	}

	public function show($id)
	{
		$this->setLayout('default');
		$this->display('tag/show', array(
			'tag' => Tag::get($id)
		));
	}
	
	public function add()
	{
		if (get_request_method() == 'POST')
			return $this->_add();

		if ($data = Flash::get('post_data') !== null)
			$tag = new Tag($data);
		else
			$tag = new Tag;

		$this->display('tag/edit', array(
			'tag' => $tag
		));
	}
	
	private function _add()
	{
		$data = $_POST['tag'];

		// validation has to be done here ...

		$tag = new Tag($data);
		if (!$tag->save())
		{
			Flash::set('post_data', $data);
			Flash::set('error', 'Tag has NOT been added!');
			redirect(get_url('tag/add'));
		}
		else Flash::set('success', 'Tag has been added with success!');

		redirect(get_url('tag'));
	}
	
	public function edit($id)
	{
		if (!$tag = Tag::get($id))
		{
			Flash::set('error', 'Tag not found!');
			redirect(get_url('tag'));
		}

		// check for a form submited
		if (get_request_method() == 'POST')
			return $this->_edit($tag);

		// check if data have been posted but not saved
		if ($data = Flash::get('post_data') !== null)
			$tag = new Tag($data);

		$this->display('tag/edit', array(
			'tag' => $tag
		));
	}
	
	private function _edit($tag)
	{
		$data = $_POST['tag'];
		
		if (!$tag->save($data))
		{
			Flash::set('post_data', $data);
			Flash::set('error', 'Tag <strong>'.$tag->id.'</strong> has NOT been updated!');
			redirect(get_url('tag/edit/'.$tag->id));
		}
		else Flash::set('success', 'Tag <strong>'.$tag->id.'</strong> has been updated with success!');
		
		redirect(get_url('tag'));
	}
	
	public function delete($id)
	{
		$tag = Tag::get( $id);
		
		if (!$tag->delete())
		{
			Flash::set('error', 'Tag <strong>'.$tag->name.'</strong> has NOT been delete!');
		}
		else Flash::set('success', 'Tag <strong>'.$tag->name.'</strong> deleted!');

		redirect(get_url('tag'));
	}

	public function all()
	{
		$tags = DB::findAllFrom('Tag', '1=1 ORDER BY name');
		
		$data = array();
		foreach($tags as $tag) {
			$data[] = $tag->name;
		}

		echo $this->renderJSON($data);
	}
} // end TagController class
