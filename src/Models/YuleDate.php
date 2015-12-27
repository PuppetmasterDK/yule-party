<?php

namespace Lutzen\Models;

use Carbon\Carbon;

class YuleDate {

	/**
	 * The date to work on
	 *
	 * @var Carbon
	 */
	private $date;

	/**
	 * True if we should only look in this year
	 *
	 * @var boolean
	 */
	private $strict;

	public function __construct(Carbon $date, $strict = false) {
		$this->date = $date->copy();
		$this->strict = $strict;
	}

	/**
	 * Return the next yule party date
	 *
	 * @return Carbon
	 */
	public function getYulePartyDate() {
		$potentialDate = $this->fromDateToYuleDate($this->date->copy()->month(12)->day(1)->hour(15)->minute(0)->second(0));
		if ($this->strict || $potentialDate->isSameDay($this->date) || $potentialDate->gte($this->date)) {
			return $potentialDate;
		}

		return $this->fromDateToYuleDate($this->date->copy()->addYear(1)->month(12)->day(1)->hour(15)->minute(0)->second(0));
	}

	/**
	 * Returns the yule party date for the given year
	 *
	 * @param Carbon $date
	 * @return Carbon
	 */
	private function fromDateToYuleDate(Carbon $date) {
		while($date->dayOfWeek != Carbon::FRIDAY) {
			$date->addDay();
		}
		$date->addDays(8);

		return $date;
	}

	/**
	 * Returns true if this is the yule party is started
	 *
	 * @return bool
	 */
	public function isYulePartyStarted() {
		$yulePartyDate = $this->getYulePartyDate();
		return $yulePartyDate->isSameDay($this->date) && $yulePartyDate->lte($this->date);
	}

}
