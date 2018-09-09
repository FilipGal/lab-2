<?php

class DateTimeView {


	public function show() {
		$day = date('l');
		$dayOfMonth = date('jS');
		$month = date('F');
		$year = date('Y');
		$currentTime = date('h:i:s');

		return "<p> {$day}, the {$dayOfMonth} of {$month} {$year}. The time is {$currentTime} </p>";
	}
}