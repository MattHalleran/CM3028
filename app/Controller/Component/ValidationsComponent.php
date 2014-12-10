<?php
App::uses('Controller', 'Component');
class ValidationsComponent extends Component {
	public function __construct( $request = null, $response = null ) {
		parent::__construct($request, $response);
	}
	public function inVoting($start_date, $end_date) {
		$startDateTime = new DateTime($start_date);
		$endDateTime = new DateTime($end_date);
		$datetimenow = new DateTime('now', new DateTimeZone("Europe/London"));
		if ( $startDateTime < $datetimenow && $endDateTime > $datetimenow ) {
			return true;
		} else {
			return false;
		}
	}
	public function duplicateExists( $ranking ) {
		foreach ($ranking as $key => $value) {
			foreach ($ranking as $key1 => $value1) {
				if ( ($key != $key1) && ($value == $value1) ) {
					return true;
				}
			}
		}
		return false;
	}
}
?>