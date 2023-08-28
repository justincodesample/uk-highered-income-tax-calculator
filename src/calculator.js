

function tax_calculator() {
	basic = parseFloat(document.getElementById("basic").value);
	lwa = parseFloat(document.getElementById("lwa").value);
	prate = parseFloat( document.getElementById("prate").value );
	income = basic + lwa;
	pension_paid = income * prate;
	ni_paid = ni_paidf(income);
	tax_paid = tax_paidf(income, pension_paid);
	take_home = income - pension_paid - ni_paid - tax_paid;

	document.getElementById("basic_out").innerHTML = basic;
	document.getElementById("include_lwa").innerHTML = income;
	document.getElementById("take_home").innerHTML = take_home;
	document.getElementById("ni_paid").innerHTML = ni_paid;
	document.getElementById("pension_paid").innerHTML = pension_paid;
	document.getElementById("tax_paid").innerHTML = tax_paid;
}

function ni_paidf(income) {
	weekly = income / 52;
	bracket1 = 0;
	bracket2 = 0;
	if (weekly > 967) {
		bracket2 = (weekly - 967) * 0.0325;
		bracket1 = (967 - 242) * 0.1325;
	} else if (weekly > 242 && weekly <= 967) {
		bracket2 = 0;
		bracket1 = (weekly - 242) * 0.1325;
	} else {
		bracket2 = 0;
		bracket1 = 0;
	}

	paid = (bracket1 + bracket2) * 52;

	return paid;
}

function personal_allowance(income, pension_paid) {
	post_pension = income - pension_paid;
	pa = 0;
	if (post_pension >= 125140) {
		pa = 0;
	} else if (post_pension > 100000 && post_pension < 125140) {
		temp = post_pension - 100000;
		pa = temp / 2;
	} else {
		pa = 12570;
	}

	return pa;
}

function tax_paidf(income, pension_paid) {
	pa = personal_allowance(income, pension_paid);

	bracket1 = 0;
	bracket2 = 0;
	bracket3 = 0;
	bracket4 = 0;

	post_pension = income - pension_paid;

	if (post_pension > 150000) {
		bracket4 = post_pension - 150000;
		bracket3 = post_pension - bracket4 - 50270;
		bracket2 = post_pension - bracket4 - bracket3 - pa;
		bracket1 = pa;
	} else if (post_pension > 50270 && post_pension <= 150000) {
		bracket4 = 0;
		bracket3 = post_pension - 50270;
		bracket2 = post_pension - bracket3 - pa;
		bracket1 = pa;
	} else if (post_pension > 12570 && post_pension < 50270) {
		bracket4 = 0;
		bracket3 = 0;
		bracket2 = post_pension - pa;
		bracket1 = pa;
	} else if (post_pension > 0 && post_pension <= 12570) {
		bracket4 = 0;
		bracket3 = 0;
		bracket2 = 0;
		bracket1 = pa;
	} else {
		bracket4 = 0;
		bracket3 = 0;
		bracket2 = 0;
		bracket1 = 0;
	}

	tax_paid = (bracket2 * 0.20) + (bracket3 * 0.40) + (bracket4 * 0.45);

	return tax_paid;
}