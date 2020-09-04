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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/queue/status.js":
/*!**************************************!*\
  !*** ./resources/js/queue/status.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// Detect a 'queue closed' event
var queueChannel = Echo.channel('App.TurnipQueue.' + meta('queue-token'));
queueChannel.listen('QueueClosed', function (e) {
  // Show a notification to say the queue was closed
  alert('The Queue has been closed by the host.');
  window.location.href = meta('close-redirect');
}); // Events for position changed or booted from queue

var seekerChannel = Echo["private"]('App.TurnipSeeker.' + meta('seeker-token'));

if (meta('check-status')) {
  seekerChannel.listen('StatusChanged', function (e) {
    console.log(e);

    if (e.position <= 0) {
      // We reached the end of the queue!
      document.getElementById('dodo-code-area').innerText = e.dodoCode;
      document.getElementById('status-show-dodo-code').classList.remove('d-none');
      document.getElementById('status-in-queue').classList.add('d-none'); // Play a notification sound

      var notification = new Audio('/sounds/notification-sound.mp3');
      notification.play(); // Blink the title if the window is inactive

      blinkTitle('Dodo code received'); // Stop listening to this specific event:

      seekerChannel.stopListening('StatusChanged');
    } else {
      document.getElementById('position-area').innerText = e.position;
    }
  });
}

seekerChannel.listen('SeekerBooted', function (e) {
  // Show a notification to say they've been booted
  alert('You have been removed from the Queue.');
  window.location.href = meta('boot-redirect');
}); // Ping the server every 30 seconds to remain in the queue

function maintainSession() {
  var xmlHttp = new XMLHttpRequest(); // We don't use this for now but maybe in the future ...?
  // xmlHttp.onreadystatechange = function() { 
  // if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
  // result = JSON.parse(xmlHttp.responseText).result;
  // }
  // }

  xmlHttp.open("GET", meta('ping-route'), true); // true for asynchronous 

  xmlHttp.send(null);
}

window.setInterval(maintainSession, 30 * 1000); // Functions to blink the title when out of focus (when needed)

var timer = "";
var isBlurred = false;
var originalTitle = document.querySelector('title').innerText;

window.onblur = function () {
  isBlurred = true;
};

window.onfocus = function () {
  isBlurred = false;
  document.title = originalTitle;
  clearInterval(timer);
};

function blinkTitle(text) {
  clearInterval(timer);

  if (isBlurred) {
    timer = window.setInterval(function () {
      document.title = document.title == originalTitle ? text : originalTitle;
    }, 1000);
  }
}

/***/ }),

/***/ 2:
/*!********************************************!*\
  !*** multi ./resources/js/queue/status.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/matthew/Code/turnip-queue/resources/js/queue/status.js */"./resources/js/queue/status.js");


/***/ })

/******/ });