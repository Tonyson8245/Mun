<?php Class Article{
    public $aid;
    public $ahref;
    public $title;
    public $writing;
    public $date;

    /**
     * Article constructor.
     * @param $aid
     * @param $ahref
     * @param $title
     * @param $writing
     * @param $date
     */
    public function __construct($aid, $ahref, $title, $writing, $date)
    {
        $this->aid = $aid;
        $this->ahref = $ahref;
        $this->title = $title;
        $this->writing = $writing;
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getAid()
    {
        return $this->aid;
    }

    /**
     * @param mixed $aid
     */
    public function setAid($aid): void
    {
        $this->aid = $aid;
    }

    /**
     * @return mixed
     */
    public function getAhref()
    {
        return $this->ahref;
    }

    /**
     * @param mixed $ahref
     */
    public function setAhref($ahref): void
    {
        $this->ahref = $ahref;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getWriting()
    {
        return $this->writing;
    }

    /**
     * @param mixed $writing
     */
    public function setWriting($writing): void
    {
        $this->writing = $writing;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return serialize($this);
    }
}