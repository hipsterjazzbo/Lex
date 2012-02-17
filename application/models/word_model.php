<?php

class Word_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function get_words($sort = false)
    {
    	$words = $this->mongo_db->words->find();
    	
    	if ( ! $sort) return $words;

    	// This stupid thing is because uasort takes the array by reference
    	$sorted->phonetic     = iterator_to_array($words);
    	$sorted->alphabetical = iterator_to_array($words);

    	uasort($sorted->phonetic, array($this, 'phonetic_sort'));
    	uasort($sorted->alphabetical, array($this, 'alphabetical_sort'));

    	return $sorted;
    }

    public function save_word()
    {
    	$word = $this->input->post();

    	var_dump($word);

    	$this->mongo_db->words->insert($word);
    }

    private function phonetic_sort($a, $b)
    {
    	// $order for this method will actually be set as one of the language settings
    	$order = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		return $this->do_sort($a, $b, 'phonetic', $order);
    }

    private function alphabetical_sort($a, $b)
    {
    	$order = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		return $this->do_sort($a, $b, 'english', $order);
    }

    /**
     * Performs the comparison for uasort in $this->phonetic_sort and $this->alphabetical_sort
     * 
     * @param  array  $a     The first mongo document to compare
     * @param  array  $b     The second mongo document to compare
     * @param  string $field Which property to dort by. Either 'english' or 'phonetic'
     * @param  array  $order An array of potential phonemes, in the order to sort by.
     * @return -1, 0 or 1, depending in how $a and $b compare
     */
    private function do_sort($a, $b, $field, $order)
    {
    	// Just use the field we're sorting by.
    	$a = $a->{$field};
    	$b = $b->{$field};
    	
    	// If they're the same word, we're done. Bail.
    	if ($a == $b) return 0;

    	// Split each int an array...
    	$a = explode('', $a);
    	$b = explode('', $b);

    	// ...set a flag to detect if one word is the beginning of the other, 
    	// e.g. 'the' and 'there'...
    	$found = false;

    	// ...and find the first phoneme that's different.
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
    	// single-phoneme $a and $b from the $order array - this will be our comparison value
    	$k1 = array_search($a, $order);
    	$k2 = array_search($b, $order);

    	// One last check. If either returned false, it means that their phoneme wasn't in the 
    	// $order array. Set to zero to push to the top of the list.
    	if ($k1 === false) $k1 = 0;
    	if ($k2 === false) $k2 = 0;

    	// If they're the same, bail. Would only happen if neither sort phoneme was in the $order array
    	if ($k1 == $k2) return 0;

    	// FINALLY. If we got this far, we've got a 100% legit comparison. Sort and get the
    	// fuck outta here.
    	return ($k1 < $k2) ? -1 : 1;
    }
}