<?php
/**
 *
 */
class extSprechstundeModelDate
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
    public function getDate() {
        return $this->data['date'];
    }
    public function getSlotID() {
        return $this->data['slot_id'];
    }
    public function getInfo() {
        return $this->data['info'];
    }
    public function getUserID() {
        return $this->data['user_id'];
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
            "date" => $this->getDate(),
            "user_id" => $this->getUserID(),
            "slot_id" => $this->getSlotID(),
            "info" => $this->getInfo(),
            "user" => false
        ];
        if ($this->getUser()) {
            $collection['user'] = $this->getUser()->getCollection();
        }
        return $collection;
    }


    /**
     * @return Array[]
     */
    public static function getAllByWeek($week_start = false) {


        $day_start = date('Y-m-d',(int)$week_start + (0 * 86400));
        $day_end = date('Y-m-d',(int)$week_start + (7 * 86400));

        $where = '';
        if ($day_start && $day_end) {
            $where .= 'WHERE date >=  DATE "'.$day_start.'" AND date <= DATE "'.$day_end.'"';
        } else {
            return false;
        }
        $ret =  [];
        $dataSQL = DB::getDB()->query("SELECT * FROM ext_sprechstunde_dates ".$where);
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