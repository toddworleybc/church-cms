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
        // just needs a random book from the bible and it will generate all books.
        return $this->book('genesis')->bible;
    }


    /**
     * return all the chapters of a book
     *
     * @param Type $book insert bible book name
     * @return type Array
     **/

    public function getAllBookChapters($book) {
        $this->setBook($book);
        return $this->getBook();
    }



    /**
     * Return all verses
     *
     * @param Type $var Description
     * @return type
     **/
    public function getAllChapterVerses($book, $chapter)
    {
        $this->setBook($book);
        $this->chapter(intval($chapter));
        return $this->getChapter();
    }



    /**
     * removes space from book string
     *
     * @param Type $book Description
     * @return type string
     **/
    public function setBook($book)
    {
        //remove space from book url string
        $book = str_replace(" ", "", $book);
        // set and return the chapters in the book
        $this->book($book);
    }

}










