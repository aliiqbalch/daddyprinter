/*!
 * jQuery Time Picker Plugin v1.0.0
 * http://github.com/pbrooks
 *
 * Copyright 2011, Page Brooks
 * Licensed under the MIT license.
 * http://github.com/pbrooks
 *
 * Date: Sun Dec 18 16:44:00 2011 -0500
 */
jQuery.fn.extend({
	timePicker: function(options) {
		
		options = {};
		
		options.formatValue = function(i) {
			var h, validator;
			i.val(i.val().toUpperCase());
			
			if (isNumber(i.val()) && (i.val().length === 1 || i.val().length === 2)) {
			  h = parseInt(i.val());
			  if ((h > 0 && h < 6) || (h === 12)) {
				i.val(h + ":00 PM");
			  } else if (h >= 6 && h < 12) {
				i.val(h + ":00 AM");
			  }
			}
			if (endsWith(i.val(), "A") || endsWith(i.val(), "P")) { 
				i.val(i.val() + "M");
			}	
		}
	
		// Utilities
		var isNumber = function(i) { return !isNaN(i - 0); }				
		var endsWith = function(str, suffix) {
			return str.indexOf(suffix, str.length - suffix.length) !== -1;
		};
		var getTimesOfDay = function() {
			var times, x;
			times = [];
			
			for (x = 7; x < 17; x++) {
			  if (x < 12) times.push("" + x + ":00 AM");
			  if (x < 12) times.push("" + x + ":05 AM");
			  if (x < 12) times.push("" + x + ":10 AM");
			  if (x < 12) times.push("" + x + ":15 AM");
			  if (x < 12) times.push("" + x + ":20 AM");
			  if (x < 12) times.push("" + x + ":25 AM");
			  if (x < 12) times.push("" + x + ":30 AM");
			  if (x < 12) times.push("" + x + ":35 AM");
			  if (x < 12) times.push("" + x + ":40 AM");
			  if (x < 12) times.push("" + x + ":45 AM");
			  if (x < 12) times.push("" + x + ":50 AM");
			  if (x < 12) times.push("" + x + ":55 AM");
			  
			  
			  if (x == 12) times.push("" + x + ":00 PM");
			  if (x ==12) times.push("" + x + ":05 PM");
			  if (x ==12) times.push("" + x + ":10 PM");
			  if (x == 12) times.push("" + x + ":15 PM");
			  if (x == 12) times.push("" + x + ":20 PM");
			  if (x == 12) times.push("" + x + ":25 PM");
			  if (x == 12) times.push("" + x + ":30 PM");
			  if (x == 12) times.push("" + x + ":35 PM");
			  if (x == 12) times.push("" + x + ":40 PM");
			  if (x ==12) times.push("" + x + ":45 PM");
			  if (x == 12) times.push("" + x + ":50 PM");
			  if (x == 12) times.push("" + x + ":55 PM");
			  
			  if (x > 12) times.push("" + (x - 12) + ":00 PM");
			  if (x > 12) times.push("" + (x - 12) + ":05 PM");
			  if (x > 12) times.push("" + (x - 12) + ":10 PM");
			  if (x > 12) times.push("" + (x - 12) + ":15 PM");
			  if (x > 12) times.push("" + (x - 12) + ":20 PM");
			  if (x > 12) times.push("" + (x - 12) + ":25 PM");
			  if (x > 12) times.push("" + (x - 12) + ":30 PM");
			  if (x > 12) times.push("" + (x - 12) + ":35 PM");
			  if (x > 12) times.push("" + (x - 12) + ":40 PM");
			  if (x > 12) times.push("" + (x - 12) + ":45 PM");
			  if (x > 12) times.push("" + (x - 12) + ":50 PM");
			  if (x > 12) times.push("" + (x - 12) + ":55 PM");
			 
			}
			return times;
		};
	
		$(document).click(function(e) {
			return $(".timePicker").hide();
		});
		
		var hideTimePickers = function(except) {
			var currentList, currentValue, listItems;
			currentList = $(except);
			currentValue = currentList.prev().val().toLowerCase();
			listItems = currentList.show().find("li");
			listItems.each(function() {
			  var li;
			  li = $(this);
			  if (li.text().toLowerCase() === currentValue) {
				li.addClass("timePicker-selected");
				return currentList.scrollTop(li.position().top - 60);
			  } else {
				return li.removeClass("timePicker-selected");
			  }
			});
			return $(".timePicker").not(except).hide();
		  };

		return this.each(function() {
			var i, newItem, pickerList, x, _i, _len, _ref;
			
			i = $(this);
			
			i.focus(function(e) {
			  return hideTimePickers(i.next());
			}).click(function(e) {
			  return e.stopPropagation();
			});
			
			i.keydown(function(e) {
				var li;
				if (e.which === 13) {
					i.val(i.next().find("li.timePicker-selected").text());
					i.next().hide();
					return false;
				}	 
				else if (e.which !== 38 && e.which !== 40) {
					$(".timePicker").hide();
					return
				} else if (e.which === 40) {
					li = i.next().find("li.timePicker-selected").removeClass("timePicker-selected");
					if (li.next().length === 0) {
						i.next().find("li:first-child").addClass("timePicker-selected");
						i.next().scrollTop(0);
						return;
					} else {
						li.next().addClass("timePicker-selected");
					}
					
					if (li.position().top > 60 - li.height()) {
						i.next().scrollTop(i.next().scrollTop() + li.height());
						return;
					}
				} 
				else if (e.which === 38) {
					li = i.next().find("li.timePicker-selected").removeClass("timePicker-selected");
					if (li.prev().length === 0) {
						i.next().find("li:last-child").addClass("timePicker-selected");
						i.next().scrollTop(i.next().find("li:last-child").position().top);
						return;
					} else {
						li.prev().addClass("timePicker-selected");
					}
					
					if (li.position().top < 60 + li.height()) {
						i.next().scrollTop(i.next().scrollTop() - li.height());
						return;
					}
				}
			}).blur(function() {
				options.formatValue(i);
				return;
			});
			
			newItem = $("<div class=\"timePicker\"><ul></ul></div>");
			newItem.hide();
			i.after(newItem);
			pickerList = newItem.children("ul");
			_ref = getTimesOfDay();
			
			for (_i = 0, _len = _ref.length; _i < _len; _i++) {
				pickerList.append("<li><p>" + _ref[_i] + "</p></li>");
			}
			
			pickerList.children("li").click(function() {
				var child = $(this);
				i.val(child.text());
				child.parent().parent().hide();
				return;
			});
			
			return;
		});
}});
