<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends Lex_Controller {

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
}

/* End of file action.php */
/* Location: ./application/controllers/action.php */