<?php

class saveDate extends AbstractRest {
	
	protected $statusCode = 200;

	public function execute($input, $request) {


        $userID = DB::getSession()->getUser()->getUserID();
        if (!$userID) {
            return [
                'error' => true,
                'msg' => 'Missing User ID'
            ];
        }

        if (!$input['date'] || !$input['slot_id'] ) {
            //die('missing data');
            return [
                'error' => true,
                'msg' => 'Missing Data'
            ];
        }

        //$time = DateTime::createFromFormat('H:i', $input['timeHour'].':'.$input['timeMinute'] );
        //$time_str = $time->format('H:i');

        $info = trim(DB::getDB()->escapeString($input['info']));
        if (!$info || $info == 'undefined') {
            $info = '';
        }
        if (!DB::getDB()->query("INSERT INTO ext_sprechstunde_dates
				(
				    date,
					slot_id,
					info,
					user_id
				) values(
					'" . DB::getDB()->escapeString($input['date']) . "',
					'" . (int)$input['slot_id'] . "',
					'" . $info . "',
					$userID
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