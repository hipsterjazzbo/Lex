<?php

class Lex_Controller extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();

		$this->set_language_menu();
	}

	public function set_language_menu()
	{
		$current_language = $this->session->userdata('current_language');
		$languages        = $this->session->userdata('languages');

		if ( ! $current_language)
		{
			$this->session->set_userdata('current_language', array_shift($languages));
		}

		if ( ! $languages)
		{
			$this->session->set_userdata('languages', $this->language_model->get_languages());
		}
	}

}