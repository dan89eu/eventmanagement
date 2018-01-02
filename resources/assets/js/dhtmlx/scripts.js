(function () {
	scheduler.locale.labels.section_text = 'Email Name';
	scheduler.locale.labels.section_event = 'Event';
	scheduler.locale.labels.section_status = 'Email Status';
	scheduler.locale.labels.section_evtStatus = 'Event Status';
	scheduler.locale.labels.section_is_paid = 'Paid';
	scheduler.locale.labels.section_time = 'Time';
	scheduler.locale.labels.section_email = 'Email sent';
	scheduler.xy.scale_height = 30;
	scheduler.config.click_form_details = true;
	scheduler.config.details_on_create = false;
	scheduler.config.details_on_dblclick = false;
	scheduler.config.dblclick_create = false;
	scheduler.config.prevent_cache = true;
	scheduler.config.show_loading = true;
	scheduler.config.xml_date = "%Y-%m-%d";
	scheduler.config.drag_resize = false;
	scheduler.locale.labels["send_now_button"] = "Send now";
	scheduler.locale.labels["upload_file_button"] = "Upload file";
	scheduler.locale.labels["event_page_button"] = "Event page";


	var eventsArr = scheduler.serverList("event");
	var eventsTypesArr = scheduler.serverList("eventType");
	var eventsStatusesArr = scheduler.serverList("eventStatus");
	var currentEventsArr = scheduler.serverList("currentEvents");

	var oldEvent = {};


	scheduler.config.lightbox.sections = [
		{map_to: "event", name: "event", type: "select", options: scheduler.serverList("currentEvents")},
		{map_to: "status", name: "status", type: "select", options: scheduler.serverList("campaignStatus")},
		{map_to: "status", name: "evtStatus", type: "select", options: scheduler.serverList("eventStatus")},
		{map_to: "text", name: "text", type: "textarea", height: 26},
		{map_to: "sent", name: "email", type: "checkbox", checked_value: true, unchecked_value: false},
	];

	scheduler.locale.labels.timeline_tab = 'Timeline';

	scheduler.createTimelineView({
		fit_events: true,
		name: "timeline",
		y_property: "event",
		render: 'bar',
		x_unit: "day",
		x_date: "%d",
		x_size: 61,
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

	function findInArray(array, key) {
		for (var i = 0; i < array.length; i++) {
			if (key == array[i].id) {
				return array[i];
			}
		}
		return null;
	}

	function getRoomType(key) {

		return findInArray(eventsTypesArr, key).name;
	}

	function getRoomStatus(key) {
		return findInArray(eventsStatusesArr, key);
	}

	function getRoom(key) {
		return findInArray(eventsArr, key);
	}

	scheduler.templates.timeline_scale_label = function (key, label, section) {
		var roomStatus = getRoomStatus(section.status);
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

	/*scheduler.templates.timeline_scale_date = function (date) {
		var timeline = scheduler.matrix.timeline;
		var func=scheduler.date.date_to_str(timeline.x_date||scheduler.config.hour_date);
		if(date.getDay()==1)
		return func(date);
		else return "";
	};

	scheduler.templates.timeline_scalex_class = function(date){
		if(date.getDay()==1)
			return func(date);
		else return "";
	};*/

	scheduler.date.timeline_start = scheduler.date.month_start;
	scheduler.date.add_timeline = function (date, step) {
		return scheduler.date.add(date, step, "month");
	};

	scheduler.attachEvent("onBeforeViewChange", function (old_mode, old_date, mode, date) {
		var year = date.getFullYear();
		var month = (date.getMonth() + 1);
		var d = new Date(year, month, 0);
		var daysInMonth = d.getDate();
		//scheduler.matrix["timeline"].x_size = daysInMonth;
		return true;
	});

	scheduler.templates.event_class = function (start, end, event) {
		if (event.id > 1000000000)
			return "room_status_indicator_" + (event.status || "");

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
		if(event.id<1000000000)
		if (event.status == 4) {
			return "<div class='booking_status booking-option'>&#10003; &#10003;</div>";
		} else if (event.status == 3) {
			return "<div class='booking_status booking-option'>&#10003;</div>";
		}

		return "";

	};

	scheduler.templates.tooltip_text = function (start, end, event) {
		var room = getRoom(event.event) || {label: ""};

		var html = [];
		if (event.id < 1000000000) {
			html.push("Detail: <b>" + event.text + "</b>");
			html.push("Event: <b>" + room.label + "</b>");
			html.push("Date: <b>" + eventDateFormat(start) + "</b>");
			html.push(room.sent);
		}else{
			html.push("Event: <b>" + room.label + "</b>");
			html.push("Begin Date: <b>" + eventDateFormat(start) + "</b>");
			html.push("End Date: <b>" + eventDateFormat(end) + "</b>");
		}
		return html.join("<br>")
	};

	scheduler.templates.lightbox_header = function (start, end, ev) {
		var formatFunc = scheduler.date.date_to_str('%d.%m.%Y');
		return formatFunc(start) + " - " + formatFunc(end);
	};

	scheduler.attachEvent('onEventCreated', function (event_id) {
		var ev = scheduler.getEvent(event_id);
		ev.status = 1;
		ev.is_paid = false;
		ev.text = 'new booking';
	});

	scheduler.addMarkedTimespan({days: [0, 6], zones: "fullday", css: "timeline_weekend"});

	window.updateSections = function updateSections(value) {

		var currenteventsArr = [];
		if (value == 'all') {
			scheduler.updateCollection("currentEvents", eventsArr.slice());
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

	scheduler.attachEvent("onBeforeLightbox", function (id) {

		var task = scheduler.getEvent(id);
		console.log(id, task);
		scheduler.resetLightbox();
		if (id > 1000000000) {

			scheduler.config.buttons_right = ["upload_file_button","event_page_button"];
			scheduler.config.lightbox.sections = [
				{map_to: "event", name: "event", type: "select", options: scheduler.serverList("currentEvents")},
				{map_to: "status", name: "evtStatus", type: "select", options: scheduler.serverList("eventStatus")}
			];
		} else {

			scheduler.config.buttons_right = ["send_now_button"];
			scheduler.config.lightbox.sections = [
				{map_to: "event", name: "event", type: "select", options: scheduler.serverList("currentEvents")},
				{map_to: "status", name: "status", type: "select", options: scheduler.serverList("campaignStatus")},
				{map_to: "text", name: "text", type: "textarea", height: 26},
				{map_to: "sent", name: "email", type: "checkbox", checked_value: true, unchecked_value: false},
			];
		}


		console.log(scheduler.serverList("campaignStatus"));
		return true;
	});


	scheduler.attachEvent("onLightbox", function(id){
		oldEvent=jQuery.extend(true,{},scheduler.getEvent(id)); //use it to get the object of the dragged event
		var section = scheduler.formSection("event");
		section.control.disabled = true;
		if(id<1000000000){
			try{
				var section = scheduler.formSection("text");
				console.log(section);
				console.log(section.control);
				if(section.control){
					section.control.disabled = true;
				}
			}catch (e)
			{
				console.error(e);
			}
		}

	});

	scheduler.attachEvent("onLightboxButton", function (button_id, node, e) {
		console.log(e);
		console.log(node);
		console.log(scheduler.getState());

		if (button_id == "send_now_button") {
			console.log("send_now_button");
		}
		switch (button_id){
			case "send_now_button":
				break;
			case "upload_file_button":

				$('#input-id').fileinput('clear');

				$("#input-b9").fileinput({
					showPreview: true,
					showUpload: true,
					elErrorContainer: '#kartik-file-errors',
					uploadUrl: '/admin/file/upload',
					uploadExtraData:{event_id:(scheduler.getState().select_id-1000000000),status:scheduler.formSection('evtStatus').getValue()}
				});

				$('#exampleModal').modal('show');

				break;
			case "event_page_button":
				window.open ('events/'+(scheduler.getState().select_id-1000000000),'_blank')
				break;
		}
		return true;
	});

	scheduler.attachEvent("onEventSave",function(id,ev,is_new){
		console.log(id,ev,is_new)
		return true;
	})
	scheduler.attachEvent("onEventChanged", function(id,ev){
		console.log(id,ev)
		console.log(oldEvent);

		var diffObj = _.omit(ev, function(v,k) { return String(oldEvent[k]) == String(v); });

		console.log(diffObj);

		if(id>1000000000){
			//TODO: event update
			$.post( "/admin/events/"+(id-1000000000),diffObj, function( data ) {
				console.log(data );
				scheduler.setCurrentView();
			});
		}else{
			//TODO: campaign update
			if(diffObj['start_date']){
				diffObj['date'] = moment(diffObj['start_date']).format('YYYY-MM-DD');
				delete diffObj['start_date'];
				delete diffObj['end_date'];
			}
			$.post( "/admin/campaigns/"+id,diffObj, function( data ) {
				console.log(data );
			});
		}

	});

	scheduler.attachEvent("onBeforeDrag", function (id, mode, e){
		oldEvent=jQuery.extend(true,{},scheduler.getEvent(id)); //use it to get the object of the dragged event
		return true;
	});

	scheduler.attachEvent("onYScaleDblClick", function(index,section,event){
		console.log(index,section,event);
		scheduler.showLightbox(section.id+1000000000);
	});

	window.onload = function () {
		init();
	};

})();

function init() {
	scheduler.init('scheduler_here', new Date(), "timeline");
	scheduler.load("events/data", "json");
	//window.dp = new dataProcessor("events/data2");
	//dp.init(scheduler);


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
