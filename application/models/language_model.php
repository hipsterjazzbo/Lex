<?php

class Language_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function get_languages()
    {
        $languages = $this->mongo_db->languages->find()->sort(array('name' => 1));

        return iterator_to_array($languages);
    }

    public function get_language_by_id($_id)
    {
        return $this->mongo_db->languages->findOne(array('_id' => new MongoId($_id)));
    }

    public function save_language()
    {
        $language = $this->input->post();

        if (empty($language['phoneme_order']))
        {
            $language['phoneme_order'] = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        }

        else
        {
            // Split the comma-separated phones into an array, and trim each one in case they were
            // typed like "a, b, c..."
            $language['phoneme_order'] = explode(',', $language['phoneme_order']);
            array_walk($language['phoneme_order'], 'trim');
        }

        $this->mongo_db->languages->insert($language);

        return $language;
    }
}