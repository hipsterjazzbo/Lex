<?php

class Lex_Controller extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();

		$this->session->set_userdata('languages', $this->language_model->get_languages());
	}

}