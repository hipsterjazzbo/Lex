<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Lex_Controller {

	public function index()
	{
		$this->list_words();
	}

	public function list_words()
	{
		$data['language'] = 'Elysian';
		//$data['words']    = $this->word_model->get_words(true);

		$this->template->build('list_words', $data);
	}

	public function add_word()
	{
		$data['language'] = 'Elysian';

		$this->template->build('add_word', $data);
	}

	public function add_language()
	{
		$data['language'] = 'Elysian';

		$this->template->build('add_language', $data);
	}
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */