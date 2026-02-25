// Use timeout to reduce flickering when calling manually
var timestampTimeout;
function updateTimestamps() {
    window.clearTimeout(timestampTimeout);
    timestampTimeout = window.setTimeout(updateTimestamps, 1000);

    document.querySelectorAll('[data-relative-from-timestamp]').forEach(function(element) {
        element.innerText = timeToGo(
            element.getAttribute('data-relative-from-timestamp'),
            element.getAttribute('data-display-long') === 'true',
        );
    });
}

updateTimestamps();

function queueClosed(e) {
    // Show a notification to say the queue was closed
    alert('The Queue has been closed by the host.');
    window.location.href = meta('close-redirect');
}

function queueExpiryChanged(e) {
    // Expiry time was changed
    document.getElementById('expiry-display').setAttribute('data-relative-from-timestamp', e.newExpiry);
}

function messageSent(message) {
    var messageSection = document.getElementById('message-section');

    var messageDiv = document.createElement('div');
    messageDiv.id = 'queue-message-' + message.id;
    messageDiv.classList.add('shadow-sm');
    messageDiv.classList.add('rounded');
    messageDiv.classList.add('border');
    messageDiv.classList.add('p-2');
    messageDiv.classList.add('mb-3');

    var timestamp = document.createElement('small');
    timestamp.setAttribute('data-relative-from-timestamp', message.sent_at);
    timestamp.setAttribute(' data-display-long', 'true');
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
}

function messageDeleted(divId) {
    document.getElementById(divId).remove();

    if(document.getElementById('message-section').children.length === 0) {
        document.getElementById('messages-header').classList.add('d-none');
    }
}

function updateMessages(messages) {
    // Add messages currently missing
    messages.forEach(function(message) {
        messageElement = document.getElementById('queue-message-' + message.id);
        if (messageElement === null) {
            messageSent(message);
        }
    });

    // Delete messages not in the list
    let messageIds = messages.map(m => 'queue-message-' + m.id);
    let visibleMessages = Array(...document.getElementById('message-section').children).map(c => c.id);
    let toRemove = visibleMessages.filter(m => !messageIds.includes(m));

    toRemove.forEach(id => messageDeleted(id));
}

function dodoCodeChanged(e) {
    document.getElementById('dodo-code-area').innerText = e.newDodoCode;
}

function statusChanged(e, notifyUser = true) {
    if(e.dodoCode) {
        // We reached the end of the queue!

        if(notifyUser && document.getElementById('status-show-dodo-code').classList.contains('d-none')) {
            // Play a notification sound
            playNotificationSound();

            // Blink the title if the window is inactive
            blinkTitle('Dodo code received');
        }

        // Update visuals
        document.getElementById('dodo-code-area').innerText = e.dodoCode;
        document.getElementById('status-show-dodo-code').classList.remove('d-none');
        document.getElementById('status-in-queue').classList.add('d-none');
    } else {
        document.getElementById('position-area').innerText = e.position;
        document.getElementById('status-show-dodo-code').classList.add('d-none');
        document.getElementById('status-in-queue').classList.remove('d-none');
    }

    document.getElementById('ping-time').setAttribute('data-relative-from-timestamp', (new Date()).toISOString());
    updateTimestamps();
}

function seekerBooted(e) {
    // Show a notification to say they've been booted
    alert('You have been removed from the Queue.');
    window.location.href = meta('boot-redirect');
}

function getCurrentStatus() {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            response = JSON.parse(xmlHttp.responseText);
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
                updateMessages(response.messages);
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
}

// Fetch the current status every 5 seconds
window.setInterval(getCurrentStatus, 5 * 1000);

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
    var b = s.split(/[-TZ:+]/i);
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
    var inThePast = diff <= 0;
    diff = Math.abs(diff);

    // Boost less than a second to be one second
    if (diff < 1e3) {
        diff = 1e3;
    }

    // Get time components
    var hours = diff/3.6e6 | 0;
    var mins  = diff%3.6e6 / 6e4 | 0;
    var secs  = Math.round(diff%6e4 / 1e3);

    if(l) {
        // return formatted string
        var result = '';

        if (!inThePast) {
            result += 'in ';
        }

        if (hours != 0) {
            result += z(hours) + ' hours, ';
        }

        if (mins != 0 || hours != 0) {
            result += z(mins) + ' minutes, ';
        }

        result += z(secs) + ' seconds';

        if (inThePast) {
            result += ' ago';
        }

        return result;

        // return sign + ' ' + z(hours) + ' hours, ' + z(mins) + ' minutes, ' + z(secs) + ' seconds';
    }
    return (inThePast ? '-' : '') + z(hours) + ':' + z(mins) + ':' + z(secs);
}
