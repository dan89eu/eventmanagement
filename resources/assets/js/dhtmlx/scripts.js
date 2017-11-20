(function () {
	scheduler.locale.labels.section_text = 'Email Name';
	scheduler.locale.labels.section_event = 'Event';
	scheduler.locale.labels.section_status = 'Event Status';
	scheduler.locale.labels.section_is_paid = 'Paid';
	scheduler.locale.labels.section_time = 'Time';
	scheduler.locale.labels.section_email = 'Email sent';
	scheduler.xy.scale_height = 30;
	scheduler.config.details_on_create = false;
	scheduler.config.details_on_dblclick = false;
	scheduler.config.dblclick_create = false;
	scheduler.config.prevent_cache = true;
	scheduler.config.show_loading = true;
	scheduler.config.xml_date = "%Y-%m-%d";
	scheduler.config.drag_resize= false;

	var eventsArr = scheduler.serverList("event");
	var eventsTypesArr = scheduler.serverList("eventType");
	var eventsStatusesArr = scheduler.serverList("eventStatus");

	scheduler.config.lightbox.sections = [
		{map_to: "event", name: "event", type: "select", options: scheduler.serverList("currentEvents")},
		{map_to: "status", name: "status", type: "radio", options: scheduler.serverList("eventStatus")},
		{map_to: "text", name: "text", type: "textarea", height: 26},
		{map_to: "sent", name: "email", type: "checkbox", checked_value:true, unchecked_value:false},
	];

	scheduler.locale.labels.timeline_tab = 'Timeline';

	scheduler.createTimelineView({
		fit_events: true,
		name: "timeline",
		y_property: "event",
		render: 'bar',
		x_unit: "day",
		x_date: "%d",
		x_size: 100,
		dy: 30,
		dx: 250,
		event_dy: "full",
		round_position: true,

		y_unit: scheduler.serverList("currentEvents"),
		second_scale: {
			x_unit: "month",
			x_date: "%F %Y"
		}
	});

	console.log(scheduler.serverList("currentEvents"));

	function findInArray(array, key) {
		for (var i = 0; i < array.length; i++) {
			if (key == array[i].id){
				console.log(array[i]);
				return array[i];
			}
		}
		return null;
	}

	function getRoomType(key) {

		console.log(key,eventsTypesArr,findInArray(eventsTypesArr, key));

		return findInArray(eventsTypesArr, key).name;
	}

	function getRoomStatus(key) {
		return findInArray(eventsStatusesArr, key);
	}

	function getRoom(key) {
		return findInArray(eventsArr, key);
	}

	scheduler.templates.timeline_scale_label = function (key, label, section) {
		console.log(key,label,section);
		var roomStatus = getRoomStatus(section.status);
		console.log(roomStatus);
		return ["<div class='timeline_item_separator'></div>",
			"<div class='timeline_item_cell'>" + label + "</div>",
			"<div class='timeline_item_separator'></div>",
			"<div class='timeline_item_cell'>" + getRoomType(section.type) + "</div>",
			"<div class='timeline_item_separator'></div>",
			"<div class='timeline_item_cell room_status'>",
			"<span class='room_status_indicator room_status_indicator_" + roomStatus.id + "'></span>",
			"<span class='status-label'>" + roomStatus.label + "</span>",
			"</div>"].join("");
	};

	scheduler.date.timeline_start = scheduler.date.month_start;
	scheduler.date.add_timeline = function (date, step) {
		console.log(date,step);
		return scheduler.date.add(date, step, "month");
	};

	scheduler.attachEvent("onBeforeViewChange", function (old_mode, old_date, mode, date) {
		console.log(old_mode, old_date, mode, date);
		var year = date.getFullYear();
		var month = (date.getMonth() + 1);
		var d = new Date(year, month, 0);
		var daysInMonth = d.getDate();
		scheduler.matrix["timeline"].x_size = daysInMonth;
		return true;
	});

	scheduler.templates.event_class = function (start, end, event) {
		return "event_" + (event.status || "");
	};

	function getBookingStatus(key) {
		var bookingStatus = findInArray(bookingStatusesArr, key);
		return !bookingStatus ? '' : bookingStatus.label;
	}

	function getPaidStatus(isPaid) {
		return isPaid ? "paid" : "not paid";
	}

	var eventDateFormat = scheduler.date.date_to_str("%d %M %Y");
	scheduler.templates.event_bar_text = function (start, end, event) {
		var paidStatus = getPaidStatus(event.is_paid);
		var startDate = eventDateFormat(event.start_date);
		return "";//[event.text + "<br />","<div class='booking_status booking-option'>" + getRoomStatus(event.status).label + "</div>"].join("");
	};

	scheduler.templates.tooltip_text = function (start, end, event) {
		var room = getRoom(event.event) || {label: ""};

		console.log(event);

		var html = [];
		html.push("Detail: <b>" + event.text + "</b>");
		html.push("Event: <b>" + room.label + "</b>");
		html.push("Date: <b>" + eventDateFormat(start) + "</b>");
		html.push(room.sent);
		return html.join("<br>")
	};

	scheduler.templates.lightbox_header = function (start, end, ev) {
		var formatFunc = scheduler.date.date_to_str('%d.%m.%Y');
		return formatFunc(start) + " - " + formatFunc(end);
	};

	scheduler.attachEvent("onEventCollision", function (ev, evs) {
		for (var i = 0; i < evs.length; i++) {
			if (ev.room != evs[i].room) continue;
			dhtmlx.message({
				type: "error",
				text: "This room is already booked for this date."
			});
		}
		return true;
	});

	scheduler.attachEvent('onEventCreated', function (event_id) {
		var ev = scheduler.getEvent(event_id);
		ev.status = 1;
		ev.is_paid = false;
		ev.text = 'new booking';
	});

	scheduler.addMarkedTimespan({days: [0, 6], zones: "fullday", css: "timeline_weekend"});

	window.updateSections = function updateSections(value) {

		console.log(value);
		console.log(eventsArr.slice());

		var currenteventsArr = [];
		if (value == 'all') {
			scheduler.updateCollection("currentEvents", eventsArr.slice());

			console.log(scheduler.serverList("currentEvents"));
			return
		}
		for (var i = 0; i < eventsArr.length; i++) {
			if (value == eventsArr[i].type) {
				currenteventsArr.push(eventsArr[i]);
			}
		}
		scheduler.updateCollection("currentEvents", currenteventsArr);
	};

	scheduler.attachEvent("onXLE", function () {
		updateSections("all");

		var select = document.getElementById("room_filter");
		var selectHTML = ["<option value='all'>All</option>"];
		for (var i = 1; i < eventsTypesArr.length + 1; i++) {
			selectHTML.push("<option value='" + i + "'>" + getRoomType(i) + "</option>");
		}
		select.innerHTML = selectHTML.join("");
	});

	scheduler.attachEvent("onEventSave", function (id, ev, is_new) {
		if (!ev.text) {
			dhtmlx.alert("Text must not be empty");
			return false;
		}
		return true;
	});

	scheduler.attachEvent("onLightbox", function(){
		var section = scheduler.formSection("text");
		section.control.disabled = true;
		var section = scheduler.formSection("event");
		section.control.disabled = true;
		var section = scheduler.formSection("event");
		section.control.disabled = true;
	});

	/*scheduler.attachEvent("onYScaleDblClick", function(index,section,event){
		console.log(index,section,event);
	});*/

	window.onload = function(){
		console.log("body load");
		init();
	};

})();

function init() {
	scheduler.init('scheduler_here', new Date(), "timeline");
	scheduler.load("events/data", "json");
	window.dp = new dataProcessor("events/data2");
	dp.init(scheduler);


	(function () {
		var element = document.getElementById("scheduler_here");
		var top = scheduler.xy.nav_height + 1 + 1;// first +1 -- blank space upper border, second +1 -- hardcoded border length
		var height = scheduler.xy.scale_height;
		var width = scheduler.matrix.timeline.dx;
		var header = document.createElement("div");
		header.className = "collection_label";
		header.style.position = "absolute";
		header.style.top = top + "px";
		header.style.width = width + "px";
		header.style.height = height + "px";

		var descriptionHTML = "<div class='timeline_item_separator'></div>" +
			"<div class='timeline_item_cell'>Event</div>" +
			"<div class='timeline_item_separator'></div>" +
			"<div class='timeline_item_cell'>Category</div>" +
			"<div class='timeline_item_separator'></div>" +
			"<div class='timeline_item_cell room_status'>Status</div>";
		header.innerHTML = descriptionHTML;
		element.appendChild(header);
	})();
}
