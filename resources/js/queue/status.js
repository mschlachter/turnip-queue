// Detect a 'queue closed' event
var queueChannel = Echo.channel('App.TurnipQueue.' + meta('queue-token'));

queueChannel.listen('QueueClosed', function(e) {
    // Show a notification to say the queue was closed
    alert('The Queue has been closed by the host.');
    window.location.href = meta('close-redirect');
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

// Ping the server every 30 seconds to remain in the queue
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

window.setInterval(maintainSession, 30 * 1000);

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