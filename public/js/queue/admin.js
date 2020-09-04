/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/queue/admin.js":
/*!*************************************!*\
  !*** ./resources/js/queue/admin.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var queueDetailsForm = document.getElementById("form-queue-details");
var visitorSlider = document.getElementById("visitors");
var visitorOutput = document.getElementById("visitors-display");
visitorOutput.innerHTML = visitorSlider.value; // Display the default slider value
// Update the current slider value (each time you drag the slider handle)

visitorSlider.oninput = function () {
  visitorOutput.innerHTML = this.value;
};

queueDetailsForm.onreset = function () {
  setTimeout(function () {
    visitorOutput.innerHTML = visitorSlider.value;
  }, 1);
}; // Listen for events (updates the list, in this case)


Echo["private"]('App.TurnipQueue.' + meta('queue-token')).listen('QueueChanged', function (e) {
  var seekers = e.newQueue; // Construct the new tbody

  var newTBody = document.createElement('tbody');

  for (i = 0; i < seekers.length; i++) {
    var seekerRow = document.createElement('tr');
    var reddit_username_row = document.createElement('td');
    reddit_username_row.innerText = seekers[i].reddit_username;
    seekerRow.appendChild(reddit_username_row);
    var island_name_row = document.createElement('td');
    island_name_row.innerText = seekers[i].in_game_username + ' from ' + seekers[i].island_name;
    seekerRow.appendChild(island_name_row);
    var custom_answer_row = document.createElement('td');
    custom_answer_row.innerText = seekers[i].custom_answer;
    seekerRow.appendChild(custom_answer_row);
    var joined_queue_row = document.createElement('td');
    joined_queue_row.innerText = timeToGo(seekers[i].joined_queue);
    joined_queue_row.setAttribute('data-relative-from-timestamp', seekers[i].joined_queue);
    seekerRow.appendChild(joined_queue_row);
    var status_row = document.createElement('td');
    status_row.innerText = i < e.concurrentVisitors ? 'Has code' : 'In queue';
    seekerRow.appendChild(status_row);
    newTBody.appendChild(seekerRow);
  } // Update the table body:


  var curTableBody = document.getElementById('queue-table-body');
  curTableBody.innerHTML = newTBody.innerHTML;
}); // Detect a 'queue closed' event

Echo.channel('App.TurnipQueue.' + meta('queue-token')).listen('QueueClosed', function (e) {
  alert('The Queue has expired.');
  window.location.href = meta('expire-redirect');
}); // Copy to clipboard button:

function fallbackCopyTextToClipboard(text, button) {
  var textArea = document.createElement("textarea");
  textArea.value = text; // Avoid scrolling to bottom

  textArea.style.top = "0";
  textArea.style.left = "0";
  textArea.style.position = "fixed";
  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();
  textArea.setSelectionRange(0, 99999);

  try {
    var successful = document.execCommand('copy');

    if (successful) {
      textCopied(text, button);
    } else {
      console.log('Fallback: Copying text command was unsuccessful');
    }
  } catch (err) {
    console.error('Fallback: Oops, unable to copy', err);
  }

  document.body.removeChild(textArea);
}

function copyTextToClipboard(text, button) {
  if (!navigator.clipboard) {
    fallbackCopyTextToClipboard(text, button);
    return;
  }

  navigator.clipboard.writeText(text).then(function () {
    textCopied(text, button);
  }, function (err) {
    console.error('Async: Could not copy text: ', err);
  });
}

function textCopied(text, button) {
  alert('Copied to clipboard: ' + text);
  button.focus();
}

document.getElementById('btn-copy-link').onclick = function () {
  var link = document.getElementById('link-to-queue').href;
  copyTextToClipboard(link, this);
}; // Use 'time to go' logic for the close time


function isoToObj(s) {
  var b = s.split(/[-TZ:]/i);
  return new Date(Date.UTC(b[0], --b[1], b[2], b[3], b[4], b[5]));
}

function timeToGo(s, l) {
  // Utility to add leading zero
  function z(n) {
    return (n < 10 ? '0' : '') + n;
  } // Convert string to date object


  var d = isoToObj(s);
  var diff = d - new Date(); // Allow for previous times

  var sign = diff < 0 ? '-' : '';
  diff = Math.abs(diff); // Get time components

  var hours = diff / 3.6e6 | 0;
  var mins = diff % 3.6e6 / 6e4 | 0;
  var secs = Math.round(diff % 6e4 / 1e3);

  if (l) {
    // return formatted string
    return sign + ' ' + z(hours) + ' hours, ' + z(mins) + ' minutes, ' + z(secs) + ' seconds';
  }

  return z(hours) + ':' + z(mins) + ':' + z(secs);
}

var closeTime = document.getElementById('queue-close-time').innerText;
var timeDisplay = document.getElementById('queue-close-time');
window.setInterval(function () {
  document.querySelectorAll('[data-relative-from-timestamp]').forEach(function (element) {
    element.innerText = timeToGo(element.getAttribute('data-relative-from-timestamp'), element.getAttribute('data-display-long') === 'true');
  });
}, 1000);

/***/ }),

/***/ 1:
/*!*******************************************!*\
  !*** multi ./resources/js/queue/admin.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/matthew/Code/turnip-queue/resources/js/queue/admin.js */"./resources/js/queue/admin.js");


/***/ })

/******/ });