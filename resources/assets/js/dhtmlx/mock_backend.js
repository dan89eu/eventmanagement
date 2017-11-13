(function() {

	var storage = {
		getData: function (url, params) {
			return getSchedulerData();
		},
		saveData: function (url, params) {
			var command = parseRequestArguments(params);
			var data = JSON.parse(getSchedulerData());
			var eventsArray = data.data;

			var updatedEvent = command.event;

			switch (command.action) {
				case "inserted":
					insertEvent(updatedEvent, eventsArray);
					break;
				case "updated":
					updateEvent(updatedEvent, eventsArray);
					break;
				case "deleted":
					deleteEvent(updatedEvent, eventsArray);
					break;
			}

			updateSchedulerData(data);
			return JSON.stringify({action: command.action, tid: updatedEvent.id, sid: updatedEvent.id});
		}
	};

	function insertEvent(event, dataset) {
		var newId = event.id;// leave id unchanged
		dataset.push(event);
		return newId;
	}

	function updateEvent(event, dataset) {
		var dbEvent;
		for (var i = 0; i < dataset.length; i++) {
			if (dataset[i].id == event.id) {
				dbEvent = dataset[i];
			}
		}

		for (var i in event) {
			dbEvent[i] = event[i];
		}
	}

	function deleteEvent(event, dataset) {
		for (var i = 0; i < dataset.length; i++) {
			if (dataset[i].id == event.id) {
				dataset.splice(i, 1);
				break;
			}
		}
	}

	function updateSchedulerData(data) {
		localStorage.setItem('dhx-scheduler-hotel-booking', JSON.stringify(data));
	}

	function getSchedulerData() {
			var data = { "data":[{"room":"1","start_date":"2017-03-02","end_date":"2017-03-23","text":"A-12","id":"1","status":"1","is_paid":"1"},{"room":"1","start_date":"2017-03-07","end_date":"2017-03-7","text":"Email 1","id":"2","status":"2","is_paid":"1"},{"room":"1","start_date":"2017-03-14","end_date":"2017-03-14","text":"Email 2","id":"3","status":"2","is_paid":"1"},{"room":"1","start_date":"2017-03-21","end_date":"2017-03-21","text":"Email 3","id":"4","status":"2","is_paid":"1"},{"room":"5","start_date":"2017-03-06","end_date":"2017-03-14","text":"A-58","id":"5","status":"3","is_paid":"0"},{"room":"7","start_date":"2017-03-04","end_date":"2017-03-18","text":"A-28","id":"6","status":"4","is_paid":"0"}],"collections":{"roomType":[{"id":"1","value":"1","label":"Meetings & Events"},{"id":"2","value":"2","label":"Wedding"},{"id":"3","value":"3","label":"Anniversary"}],"roomStatus":[{"id":"1","value":"1","label":"New"},{"id":"2","value":"2","label":"Pending"},{"id":"3","value":"3","label":"In contact"},{"id":"4","value":"4","label":"Proposal sent"},{"id":"5","value":"5","label":"Won"},{"id":"6","value":"6","label":"Bid Rejected"},{"id":"6","value":"6","label":"Bid Rejected"},{"id":"7","value":"7","label":"Lost"}],"bookingStatus":[{"id":"1","value":"1","label":"New"},{"id":"2","value":"2","label":"Pending"},{"id":"3","value":"3","label":"In contact"},{"id":"4","value":"4","label":"Proposal sent"},{"id":"5","value":"5","label":"Won"},{"id":"6","value":"6","label":"Bid Rejected"},{"id":"6","value":"6","label":"Bid Rejected"},{"id":"7","value":"7","label":"Lost"}],"room":[{"id":"1","value":"1","label":"My Event","type":"1","status":"1"},{"id":"2","value":"2","label":"Apple 2017","type":"1","status":"3"},{"id":"3","value":"3","label":"Google I/O","type":"1","status":"2"},{"id":"4","value":"4","label":"My Wedding","type":"2","status":"1"},{"id":"5","value":"5","label":"My Birthday","type":"3","status":"1"}]}};

			console.log(JSON.stringify(data));

			return JSON.stringify(data);
	}

	function parseRequestArguments(params) {
		var parts = decodeURIComponent(params).split("&");

		var fieldsMap = {};
		for (var i = 0; i < parts.length; i++) {
			var param = parts[i].split("=");
			fieldsMap[param[0]] = param[1];
		}

		var id = fieldsMap["ids"];

		var action,
			event = {};

		var prefix = id + "_";

		for (var i in fieldsMap) {
			var isEventProperty = i.indexOf(prefix) > -1;
			if (isEventProperty) {
				var fieldName = i.substr(prefix.length);

				if (fieldName == "!nativeeditor_status") {
					action = fieldsMap[i];
				} else {
					event[fieldName] = fieldsMap[i];
				}
			}
		}

		return {
			action: action,
			event: event
		};
	}

	var mockAjax = {
		call: function (httpMethod, url, params, callback) {

			var handler = this.router.route(httpMethod, url);
			if (handler) {
				this.executeRequest(httpMethod, handler, url, params, callback);
			} else {
				console.error("no route found " + this.router.urlMask(httpMethod, url));
			}
		},

		executeRequest: function (httpMethod, method, url, params, callback) {
			setTimeout(function () {
				var res = method(url, params);
				console.log(["XHR " + httpMethod.toUpperCase(), url].join(" -> "));
				setTimeout(function () {
					callback({
						filePath: url,
						xmlDoc: {
							readyState: 4,
							response: res,
							responseText: res,
							status: 200
						}
					});
				});
			});
		}
	};

	mockAjax.router = {
		routeMap: {},
		route: function (httpMethod, url) {
			return this.routeMap[this.urlMask(httpMethod, url)];
		},
		urlMask: function (httpMethod, url) {
			return [httpMethod, this._stripUrl(url)].join("->").toLowerCase();
		},
		_stripUrl: function (url) {
			var paramsIndex = url.indexOf("?");
			if (paramsIndex < 0) {
				paramsIndex = url.length;
			}

			return url.substr(0, paramsIndex);
		}
	};

	window.dhtmlxAjax = {
		get: function (url, callback) {
			mockAjax.call("get", url, null, function(res){
				console.log("get");
				callback(res);
			});
		},
		post: function (url, post, callback) {
			mockAjax.call("post", url, post, function(res){
				callback(res);
			});
		}
	};

	window.dtmlXMLLoaderObject.prototype.loadXML = function (filePath, postMode, postVars) {
		var callback = this.onloadAction;
		mockAjax.call(postMode ? "post" : "get", filePath, postVars, function(res){
			callback(window.dp, null, null, null, res);
		});
	};

	mockAjax.router.routeMap["get->./data.php"] = storage.getData.bind(storage);
	mockAjax.router.routeMap["post->./data.php"] = storage.saveData.bind(storage);

})();