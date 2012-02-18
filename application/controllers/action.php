<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends CI_Controller {

	public function index()
	{
		// Something
	}

	public function add_word()
	{
		$this->word_model->save_word();
	}

	public function add_language()
	{
		$this->language_model->save_language();
		$this->session->set_flashdata('message', "Great, <strong>{$this->input->post('name')}</strong> has been added. Now, how about some words?");
		redirect('page/add_word');
	}

	public function change_language($_id)
	{
		$language = $this->language_model->get_language_by_id($_id);
		
		$this->session->set_userdata('current_language', $language);

		redirect('page/list_words');
	}
}

/* End of file action.php */
/* Location: ./application/controllers/action.php */