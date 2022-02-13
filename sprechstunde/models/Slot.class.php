<?php
/**
 *
 */
class extSprechstundeModelSlot
{

    /**
     * @var data []
     */
    private $data = [];

    private $user = false;

    /**
     * Constructor
     * @param $data
     */
    public function __construct($data = false)
    {
        if (!$data) {
            $data = $this->data;
        }
        $this->setData($data);
    }

    /**
     * @return data
     */
    public function setData($data = [])
    {
        $this->data = $data;
        return $this->getData();
    }

    /**
     * @return data
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Getter
     */
    public function getID() {
        return $this->data['id'];
    }
    public function getTitle() {
        return $this->data['title'];
    }
    public function getUserID() {
        return $this->data['user_id'];
    }
    public function getDay() {
        return $this->data['day'];
    }
    public function getTime() {
        return $this->data['time'];
    }
    public function getDuration() {
        return $this->data['duration'];
    }

    public function getUser () {
        if (!$this->user && $this->data['user_id']) {
            $this->user = user::getUserByID($this->data['user_id']);
        }
        return $this->user;
    }

    public function getCollection() {

        $collection = [
            "id" => $this->getID(),
            "title" => $this->getTitle(),
            "user_id" => $this->getUserID(),
            "day" => $this->getDay(),
            "time" => 0,
            "duration" => $this->getDuration(),
            "user" => false
        ];
        if ($this->getTime()) {
            $timeDate = DateTime::createFromFormat('H:i:s', $this->getTime());
            $collection["time"] = $timeDate->format('H:i');
        }
        if ($this->getUser()) {
            $collection['user'] = $this->getUser()->getCollection();
        }
        return $collection;
    }


    /**
     * @return Array[]
     */
    public static function getAllByUser($user_id = false) {

        $where = '';
        if ($user_id) {
            $where .= 'WHERE user_id = '.(int)$user_id;
        } else {
            return false;
        }
        $ret =  [];
        $dataSQL = DB::getDB()->query("SELECT * FROM ext_sprechstunde_slots ".$where);
        while ($data = DB::getDB()->fetch_array($dataSQL, true)) {
            $ret[] = new self($data);
        }
        return $ret;
    }

    /**
     * @return Array[]
     */
    public static function getAll() {

        $ret =  [];
        $dataSQL = DB::getDB()->query("SELECT * FROM ext_sprechstunde_slots ");
        while ($data = DB::getDB()->fetch_array($dataSQL, true)) {
            $ret[] = new self($data);
        }
        return $ret;
    }



}