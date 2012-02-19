<?php

class Word_model extends CI_Model {

    private $sorted = array();

    function __construct()
    {
        parent::__construct();
    }

    public function get_words($sort = false)
    {
    	if ($sort)
    	{
	    	$this->alphabetical_sort();
	    	$this->phonetic_sort();

	    	return $this->sorted;
	    }

	    else
	    {
	    	return $this->mongo_db->words->find();
	    }

    	// This stupid thing is because uasort takes the array by reference
    	// $sorted['phonetic']     = iterator_to_array($words);
    	// $sorted['alphabetical'] = iterator_to_array($words);

    	// uasort($sorted['phonetic'], array($this, 'phonetic_sort'));
    	// uasort($sorted['alphabetical'], array($this, 'alphabetical_sort'));
    }

    public function save_word()
    {
    	$word = $this->input->post();

    	$this->mongo_db->words->insert($word);
    }

    private function alphabetical_sort()
    {
    	$current_language = $this->session->userdata('current_language');
        $this->order = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		$this->sort_field = 'english';

		foreach ($this->order as $phoneme)
		{
			$words = $this->mongo_db->words->find(array('language' => (string) $current_language['_id'], $this->sort_field => array('$regex' => "^{$phoneme}", '$options' => 'i')));
			$this->sorted['alphabetical'][$phoneme] = iterator_to_array($words);

			uasort($this->sorted['alphabetical'][$phoneme], array($this, 'do_sort'));
		}
    }

    private function phonetic_sort()
    {
    	$current_language = $this->session->userdata('current_language');
    	$this->order = $current_language['phoneme_order'];
		$this->sort_field = 'phonetic';

		foreach ($this->order as $phoneme)
		{
			$words = $this->mongo_db->words->find(array('language' => (string) $current_language['_id'], $this->sort_field => array('$regex' => "^{$phoneme}", '$options' => 'i')));
			$this->sorted['phonetic'][$phoneme] = iterator_to_array($words);

			uasort($this->sorted['phonetic'][$phoneme], array($this, 'do_sort'));
		}
    }

    /**
     * Performs the comparison for uasort in $this->phonetic_sort and $this->alphabetical_sort
     * 
     * @param  array  $a     The first mongo document to compare
     * @param  array  $b     The second mongo document to compare
     * @return -1, 0 or 1, depending in how $a and $b compare
     */
    private function do_sort($a, $b)
    {
    	// Just use the field we're sorting by.
    	$a = $a[$this->sort_field];
    	$b = $b[$this->sort_field];
    		
    	// If they're the same word, we're done. Bail.
    	if ($a == $b) return 0;

    	// Split each int an array...
    	$a = preg_split('//', $a, -1);
    	$b = preg_split('//', $b, -1);

    	// ...set a flag to detect if one word is the beginning of the other, 
    	// e.g. 'the' and 'there'...
    	$found = false;

    	// ...and find the first phone that's different.
    	for ($i = 0; $i < count($a) && $i < count($b); $i++)
    	{
    		if ($a[$i] != $b[$i])
    		{
    			$found = true;
    			$a = $a[$i];
    			$b = $b[$i];
    			break;
    		}
    	}

    	// If we exited the loop without setting $found to true, it means that we've got a
    	// 'the' and 'there' situation. Sort the shorter one first and bail.
    	if ( ! $found)
    	{
    		return (count($a) < count($b)) ? -1 : 1;
    	}

    	// If we got this far, we have a legitimate comparison. Get the indices of the now
    	// single-phone $a and $b from the $order array - this will be our comparison value
    	$k1 = array_search($a, $this->order);
    	$k2 = array_search($b, $this->order);

    	// One last check. If either returned false, it means that their phone wasn't in the 
    	// $order array. Set to zero to push to the top of the list.
    	if ($k1 === false) $k1 = 0;
    	if ($k2 === false) $k2 = 0;

    	// If they're the same, bail. Would only happen if neither sort phone was in the $order array
    	if ($k1 == $k2) return 0;

    	// FINALLY. If we got this far, we've got a 100% legit comparison. Sort and get the
    	// fuck outta here.
    	return ($k1 < $k2) ? -1 : 1;
    }
}