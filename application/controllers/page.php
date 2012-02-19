<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Lex_Controller {

	public function index()
	{
		$this->list_words();
	}

	public function list_words()
	{
		$data['words'] = $this->word_model->get_words(true);

		$this->template->build('list_words', $data);
	}

	public function add_word()
	{
		$this->template->build('add_word');
	}

	public function add_language()
	{
		$this->template->build('add_language');
	}

	public function manage_languages()
	{
		$data['languages'] = $this->language_model->get_languages();

		$this->template->build('manage_languages', $data);
	}
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */