(function($) {
	"use strict";
	
	//P-scrolling
	const settingsScroll1 = new PerfectScrollbar('#generalSettings', {
	  useBothWheelAxes:true,
	  suppressScrollX:true,
	});
	const settingsScroll2 = new PerfectScrollbar('#landRegSettings', {
	  useBothWheelAxes:true,
	  suppressScrollX:true,
	});
	const settingsScroll3 = new PerfectScrollbar('#notificationsSettings', {
	  useBothWheelAxes:true,
	  suppressScrollX:true,
	});
	const settingsScroll4 = new PerfectScrollbar('#secAndverifSettings', {
	  useBothWheelAxes:true,
	  suppressScrollX:true,
	});
	const settingsScroll5 = new PerfectScrollbar('#integrationSettings', {
	  useBothWheelAxes:true,
	  suppressScrollX:true,
	});
	const settingsScroll6 = new PerfectScrollbar('#otherSettings', {
	  useBothWheelAxes:true,
	  suppressScrollX:true,
	});
	
})(jQuery);