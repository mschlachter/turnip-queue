// Detect a 'queue closed' event
var queueChannel = Echo.channel('App.TurnipQueue.' + meta('queue-token'));

queueChannel.listen('QueueClosed', function(e) {
    // Show a notification to say the queue was closed
    alert('The Queue has been closed by the host.');
    window.location.href = meta('close-redirect');
});

queueChannel.listen('QueueExpiryChanged', function(e) {
    // Expiry time was changed
    document.getElementById('expiry-display').setAttribute('data-relative-from-timestamp', e.newExpiry);
});

// Events for position changed or booted from queue
var seekerChannel = Echo.private('App.TurnipSeeker.' + meta('seeker-token'));

if(meta('check-status')) {
    seekerChannel.listen('StatusChanged', function(e) {
        console.log(e);
        if(e.position <= 0) {
            // We reached the end of the queue!
            document.getElementById('dodo-code-area').innerText = e.dodoCode;
            document.getElementById('status-show-dodo-code').classList.remove('d-none');
            document.getElementById('status-in-queue').classList.add('d-none');

            // Play a notification sound
            var notification = new Audio('/sounds/notification-sound.mp3');
            notification.play();

            // Blink the title if the window is inactive
            blinkTitle('Dodo code received');

            // Stop listening to this specific event:
            seekerChannel.stopListening('StatusChanged');
        } else {
            document.getElementById('position-area').innerText = e.position;
        }
    });
}

seekerChannel.listen('SeekerBooted', function(e) {
    // Show a notification to say they've been booted
    alert('You have been removed from the Queue.');
    window.location.href = meta('boot-redirect');
});

// Ping the server every 15 seconds to remain in the queue
function maintainSession() {
    var xmlHttp = new XMLHttpRequest();
    // We don't use this for now but maybe in the future ...?
    // xmlHttp.onreadystatechange = function() { 
        // if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            // result = JSON.parse(xmlHttp.responseText).result;
        // }
    // }
    xmlHttp.open("GET", meta('ping-route'), true); // true for asynchronous 
    xmlHttp.send(null);
}

window.setInterval(maintainSession, 15 * 1000);

// Functions to blink the title when out of focus (when needed)
var timer = "";
var isBlurred = false;
var originalTitle = document.querySelector('title').innerText;
window.onblur = function() {
    isBlurred = true;
}
window.onfocus = function() { 
    isBlurred = false;
    document.title = originalTitle;
    clearInterval(timer);
}
function blinkTitle(text) {
    clearInterval(timer);
    if(isBlurred) {
        timer = window.setInterval(function() {
            document.title = document.title == originalTitle ? text : originalTitle;
        }, 1000);
    }
}

// Use 'time to go' logic for the close time
function isoToObj(s) {
    var b = s.split(/[-TZ:]/i);
    return new Date(Date.UTC(b[0], --b[1], b[2], b[3], b[4], b[5]));
}

function timeToGo(s, l) {
    // Utility to add leading zero
    function z(n) {
      return (n < 10? '0' : '') + n;
    }

    // Convert string to date object
    var d = isoToObj(s);
    var diff = d - new Date();

    // Allow for previous times
    var sign = diff < 0? '-' : '';
    diff = Math.abs(diff);

    // Get time components
    var hours = diff/3.6e6 | 0;
    var mins  = diff%3.6e6 / 6e4 | 0;
    var secs  = Math.round(diff%6e4 / 1e3);

    if(l) {
        // return formatted string
        return sign + ' ' + z(hours) + ' hours, ' + z(mins) + ' minutes, ' + z(secs) + ' seconds';   
    }
    return sign + z(hours) + ':' + z(mins) + ':' + z(secs);
}

window.setInterval(function() {
    document.querySelectorAll('[data-relative-from-timestamp]').forEach(function(element) {
        element.innerText = timeToGo(
            element.getAttribute('data-relative-from-timestamp'),
            element.getAttribute('data-display-long') === 'true',
        );
    });
}, 1000);