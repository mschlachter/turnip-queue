// Detect a 'queue closed' event
var queueChannel = Echo.channel('App.TurnipQueue.' + meta('queue-token'));

function queueClosed(e) {
    // Show a notification to say the queue was closed
    alert('The Queue has been closed by the host.');
    window.location.href = meta('close-redirect');
}

function queueExpiryChanged(e) {
    // Expiry time was changed
    document.getElementById('expiry-display').setAttribute('data-relative-from-timestamp', e.newExpiry);
}

queueChannel.listen('QueueClosed', queueClosed);

queueChannel.listen('QueueExpiryChanged', queueExpiryChanged);

queueChannel.listen('QueueMessageSent', function(e) {
    var messageSection = document.getElementById('message-section');
    var message = e.turnipQueueMessage;

    var messageDiv = document.createElement('div');
    messageDiv.id = 'queue-message-' + message.id;
    messageDiv.classList.add('shadow-sm');
    messageDiv.classList.add('rounded');
    messageDiv.classList.add('border');
    messageDiv.classList.add('p-2');
    messageDiv.classList.add('mb-3');

    var timestamp = document.createElement('small');
    timestamp.setAttribute('data-relative-from-timestamp', message.sent_at);
    timestamp.classList.add('text-muted');
    timestamp.innerText = timeToGo(message.sent_at);
    messageDiv.appendChild(timestamp);

    var messageContent = document.createElement('div');
    messageContent.classList.add('message-text');
    messageContent.classList.add('whitespace-preline');
    messageContent.innerText = message.message;
    messageDiv.appendChild(messageContent);

    if (messageSection.firstChild) {
        messageSection.insertBefore(messageDiv, messageSection.firstChild);
    } else {
        messageSection.appendChild(messageDiv);
    }
    
    document.getElementById('messages-header').classList.remove('d-none');

    // Play a notification sound
    playNotificationSound();

    // Blink the title if the window is inactive
    blinkTitle('New message from host');
});

queueChannel.listen('QueueMessageDeleted', function(e) {
    document.getElementById('queue-message-' + e.turnipQueueMessageId).remove();

    if(document.getElementById('message-section').children.length === 0) {
        document.getElementById('messages-header').classList.add('d-none');
    }
});

// Events for position changed or booted from queue
var seekerChannel = Echo.private('App.TurnipSeeker.' + meta('seeker-token'));

function dodoCodeChanged(e) {
    document.getElementById('dodo-code-area').innerText = e.newDodoCode;
}

function statusChanged(e, notifyUser = true) {
    if(e.position <= 0) {
        // We reached the end of the queue!
        document.getElementById('dodo-code-area').innerText = e.dodoCode;
        document.getElementById('status-show-dodo-code').classList.remove('d-none');
        document.getElementById('status-in-queue').classList.add('d-none');

        if(notifyUser) {
            // Play a notification sound
            playNotificationSound();

            // Blink the title if the window is inactive
            blinkTitle('Dodo code received');
        }

        // Stop listening to this specific event:
        seekerChannel.stopListening('StatusChanged');

        // Start listening to the 'dodo code changed' event
        seekerChannel.listen('DodoCodeChanged', dodoCodeChanged);
    } else {
        document.getElementById('position-area').innerText = e.position;
    }
}

function seekerBooted(e) {
    // Show a notification to say they've been booted
    alert('You have been removed from the Queue.');
    window.location.href = meta('boot-redirect');
}

if(meta('check-status')) {
    seekerChannel.listen('StatusChanged', statusChanged);
}

seekerChannel.listen('SeekerBooted', seekerBooted);

if(!meta('check-status')) {
    seekerChannel.listen('DodoCodeChanged', dodoCodeChanged);
}

// Handle reconnects after being disconnected
seekerChannel.on('pusher:subscription_succeeded', function(e) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            response = JSON.parse(xmlHttp.responseText);
            console.log(response);
            switch(response.status) {
                case 'closed':
                queueClosed(response);
                break;

                case 'booted':
                seekerBooted(response);
                break;
                
                case 'active':
                statusChanged(response, false);
                queueExpiryChanged(response);
                // TODO: update messages...
                break;
            }
        } else if(xmlHttp.readyState == 4 && xmlHttp.status == 404) {
                // If we get a 404 when checking the status, it's likely because
                // the queue doesn't exist
                queueClosed(response);
            }
        }
    xmlHttp.open("GET", meta('get-status-route'), true); // true for asynchronous 
    xmlHttp.send(null);
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

function playNotificationSound() {
    // Keeping this in one place will make it easier to add a toggle later
    var notification = new Audio('/sounds/notification-sound.mp3');
    notification.play();
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