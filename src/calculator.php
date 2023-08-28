<?php

class Tax {
	private $income = 0;
	private $lwa = 0.0;
	private $ni_paid = 0.0;
	private $pension_rate = 0.0;
	private $personal_allowance = 0.0;
	private $take_home = 0.0;
	private $tax_paid = 0.0;
	private $weekly_pay = 0.0;
	private $post_pension = 0.0;

	function __construct(float $income, float $lwa, float $pension_rate) {
		$this->income = $income;
		$this->lwa = $lwa;
		$this->pension_rate = $pension_rate;
	}

	# pension
	# income + lwa * pension contribution rate
	private function pension_paid() {
		$this->pension_paid = ($this->income + $this->lwa) * $this->pension_rate;
	}

	# take home = income + lwa
	# - ni X
	# - pension X
	# - tax X
	public function take_home() {
		$this->weekly_pay = ($this->income + $this->lwa) / 52;
		$this->ni_paid();
		$this->pension_paid();
		$this->post_pension = ($this->income + $this->lwa) - $this->pension_paid;
		$this->calculate_personal_allowance();
		$this->tax_paid();
		$this->take_home = ($this->income + $this->lwa) - $this->pension_paid - $this->tax_paid - $this->ni_paid;
		// return $this->take_home;
	}

	private function calculate_personal_allowance() {
		if ($this->post_pension >= 125140) {
			$this->personal_allowance = 0;
		} else if ($this->post_pension > 100000 && $this->post_pension < 125140) {
			$temp = $this->post_pension - 100000;
			$this->personal_allowance = $temp / 2;
		} else {
			$this->personal_allowance = 12570;
		}
	}

	# income tax
	# (income + lwa - pension) = amount
	# the amount from 0 to 12570 pay zero
	# 12571 to 50270 pay 20%
	# 50271 to 150000 pay 40%
	# > 150000 pay 45%
	# Personal Allowance goes down by £1 for every £2 that your adjusted net income is above £100,000. This means your allowance is zero if your income is £125,140 or above.
	private function tax_paid() {
		$bracket1 = 0;
		$bracket2 = 0;
		$bracket3 = 0;
		$bracket4 = 0;

		if ($this->post_pension > 150000) {
			# 45%
			$bracket4 = $this->post_pension - 150000;
			$bracket3 = $this->post_pension - $bracket4 - 50270;
			$bracket2 = $this->post_pension - $bracket4 - $bracket3 - $this->personal_allowance;
			$bracket1 = $this->personal_allowance;
		} else if ($this->post_pension > 50270 && $this->post_pension <= 150000) {
			# 40%
			$bracket4 = 0;
			$bracket3 = $this->post_pension - $bracket4 - 50270;
			$bracket2 = $this->post_pension - $bracket4 - $bracket3 - $this->personal_allowance;
			$bracket1 = $this->personal_allowance;
		} else if ($this->post_pension > 12570 && $this->post_pension <= 50270) {
			# 20%
			$bracket4 = 0;
			$bracket3 = 0;
			$bracket2 = $this->post_pension - $bracket4 - $bracket3 - $this->personal_allowance;
			$bracket1 = $this->personal_allowance;
		} else if ($this->post_pension > 0 && $this->post_pension <= 12570) {
			#  0%
			$bracket4 = 0;
			$bracket3 = 0;
			$bracket2 = 0;
			$bracket1 = $this->post_pension;
		} else {
			# none of above which shouldn't exist
			$bracket4 = 0;
			$bracket3 = 0;
			$bracket2 = 0;
			$bracket1 = 0;
		}

		$this->tax_paid = ($bracket2 * 0.20) + ($bracket3 * 0.40) + ($bracket4 * 0.45);
	}

	# NI
	# weekly salary = (income + lwa - allowance) / 52
	# 0 - 242 pay zero
	# 242 - 967 pay 13.25
	# 967.01 pay 3.25
	private function ni_paid() {
		$bracket2 = 0;
		$bracket1 = 0;

		if ($this->weekly_pay > 967) {
			# earn more than 967 per week
			$bracket2 = ($this->weekly_pay - 967) * 0.0325;
			$bracket1 = (967 - 242) * 0.1325;
		} else if ($this->weekly_pay > 242 && $this->weekly_pay <=967) {
			# earn more than 242 but less than 967 per week
			$bracket2 = 0;
			$bracket1 = ($this->weekly_pay - 242) * 0.1325;
		} else {
			# ($this->weekly_pay <= 242)
			# earn less than or equal to 242 per week
			$bracket2 = 0;
			$bracket1 = 0;
		}

		$this->ni_paid = ($bracket1 + $bracket2) * 52;
	}

	public function get_income() {
		return $this->income;
	}

	public function get_include_lwa() {
		return $this->lwa + $this->income;
	}

	public function get_ni_paid() {
		return $this->ni_paid;
	}

	public function get_pension_paid() {
		return $this->pension_paid;
	}

	public function get_pension_rate() {
		return $this->pension_rate;
	}

	public function get_take_home() {
		return $this->take_home;
	}

	public function get_tax_paid() {
		return $this->tax_paid;
	}

	public function get_weekly_pay() {
		return $this->weekly_pay;
	}
}

# Reference
# £242 to £967 a week (£1,048 to £4,189 a month), 13.25%
# Over £967 a week (£4,189 a month), 3.25%
# https://www.gov.uk/national-insurance/how-much-you-pay
?>