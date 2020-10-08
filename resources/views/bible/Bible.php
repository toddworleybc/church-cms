<?php
namespace Book\Bible;

use Djunehor\Logos\Bible as lvBible;


class Bible extends lvBible {




    /**
     * Return array of all bible books
     *
     * @return type Array
     * @throws conditon
     **/

    public function getAllBibleBooks() {
        return $this->book('genesis')->bible;
    }

}










