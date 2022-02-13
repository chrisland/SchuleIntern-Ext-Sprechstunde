<?php

class saveSlot extends AbstractRest {
	
	protected $statusCode = 200;

	public function execute($input, $request) {


        $userID = DB::getSession()->getUser()->getUserID();
        if (!$userID) {
            return [
                'error' => true,
                'msg' => 'Missing User ID'
            ];
        }

        if (!$input['timeHour'] || !$input['timeMinute'] || !$input['title'] || !$input['day'] ) {
            //die('missing data');
            return [
                'error' => true,
                'msg' => 'Missing Data'
            ];
        }

        $acl = $this->getAcl();
        if ((int)$acl['rights']['read'] !== 1) {
            return [
                'error' => true,
                'msg' => 'Kein Zugriff'
            ];
        }


        $time = DateTime::createFromFormat('H:i', $input['timeHour'].':'.$input['timeMinute'] );
        $time_str = $time->format('H:i');


        if (!DB::getDB()->query("INSERT INTO ext_sprechstunde_slots
				(
				    user_id,
					title,
					time,
					day,
				    duration
				) values(
				    $userID,
					'" . DB::getDB()->escapeString($input['title']) . "',
					'" . $time_str . "',
					'" . DB::getDB()->escapeString($input['day']) . "',
					'" . DB::getDB()->escapeString($input['duration']) . "'
				)
		    ")) {
            return [
                'error' => true,
                'msg' => 'Fehler beim Hinzufügen!'
            ];
        }

        return [
            'error' => false,
            'insert' => true
        ];




        return [
			'error' => true,
			'msg' => 'Return Data!'
		];

	}


	/**
	 * Set Allowed Request Method
	 * (GET, POST, ...)
	 * 
	 * @return String
	 */
	public function getAllowedMethod() {
		return 'POST';
	}


    /**
     * Muss der Benutzer eingeloggt sein?
     * Ist Eine Session vorhanden
     * @return Boolean
     */
    public function needsUserAuth() {
        return true;
    }

    /**
     * Ist eine Admin berechtigung nötig?
     * only if : needsUserAuth = true
     * @return Boolean
     */
    public function needsAdminAuth()
    {
        return false;
    }
    /**
     * Ist eine System Authentifizierung nötig? (mit API key)
     * only if : needsUserAuth = false
     * @return Boolean
     */
    public function needsSystemAuth() {
        return false;
    }

}	

?>