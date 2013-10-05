$(document).ready(function () {
	$('input.focus').focus();
    $('.birthdate').datepicker({ dateFormat: 'dd.mm.yy', changeMonth: true, changeYear: true, yearRange: "1900:2013" });
    $('.futuredate').datepicker({ dateFormat: 'dd.mm.yy', changeMonth: true, changeYear: true, yearRange: "2013:2023" });
});
