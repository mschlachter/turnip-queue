var queueDetailsForm = document.getElementById("form-queue-details");
var visitorSlider = document.getElementById("visitors");
var visitorOutput = document.getElementById("visitors-display");
visitorOutput.innerHTML = visitorSlider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
visitorSlider.oninput = function() {
  visitorOutput.innerHTML = this.value;
}

queueDetailsForm.onreset = function() {
    setTimeout(function() {
        visitorOutput.innerHTML = visitorSlider.value;
    }, 1);
}

// Listen for events (updates the list, in this case)
Echo.private('App.TurnipQueue.' + meta('queue-token'))
    .listen('QueueChanged', function(e) {
        var seekers = e.newQueue;

        // Construct the new tbody
        var newTBody = document.createElement('tbody');
        for(i = 0; i < seekers.length; i++) {
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

            var action_row = document.createElement('td');
            var action_form = document.createElement('form');
            action_form.classList.add('form-boot-seeker');
            action_form.setAttribute('data-confirm', 'Are you sure you want to remove ' + seekers[i].reddit_username + ' from the Queue?');
            action_form.method = 'post';
            action_form.action = meta('boot-route');

            var csrf_input = document.createElement('input');
            csrf_input.type = 'hidden';
            csrf_input.name = '_token';
            csrf_input.value = meta('csrf-token');
            action_form.appendChild(csrf_input);

            var queue_token_input = document.createElement('input');
            queue_token_input.type = 'hidden';
            queue_token_input.name = 'queue-token';
            queue_token_input.value = meta('queue-token');
            action_form.appendChild(queue_token_input);

            var seeker_token_input = document.createElement('input');
            seeker_token_input.type = 'hidden';
            seeker_token_input.name = 'seeker-token';
            seeker_token_input.value = seekers[i].token;
            action_form.appendChild(seeker_token_input);

            var remove_button = document.createElement('button');
            remove_button.type = 'submit';
            remove_button.innerText = 'Remove';
            remove_button.classList.add('btn');
            remove_button.classList.add('btn-outline-danger');
            action_form.appendChild(remove_button);

            action_row.appendChild(action_form);
            seekerRow.appendChild(action_row);

            newTBody.appendChild(seekerRow);
        }

        // Update the table body:
        var curTableBody = document.getElementById('queue-table-body');
        curTableBody.innerHTML = newTBody.innerHTML;
    });

// Detect a 'queue closed' event
Echo.channel('App.TurnipQueue.' + meta('queue-token'))
    .listen('QueueClosed', function(e) {
        alert('The Queue has expired.');
        window.location.href = meta('expire-redirect');
    });

// Copy to clipboard button:
function fallbackCopyTextToClipboard(text, button) {
    var textArea = document.createElement("textarea");
    textArea.value = text;

    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    textArea.setSelectionRange(0, 99999);

    try {
        var successful = document.execCommand('copy');
        if(successful) {
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
    navigator.clipboard.writeText(text).then(function() {
        textCopied(text, button);
    }, function(err) {
        console.error('Async: Could not copy text: ', err);
    });
}
function textCopied(text, button) {
    alert('Copied to clipboard: ' + text);
    button.focus();
}

document.getElementById('btn-copy-link').onclick = function() {
    var link = document.getElementById('link-to-queue').href;
    copyTextToClipboard(link, this);
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
    return z(hours) + ':' + z(mins) + ':' + z(secs);
}

var closeTime = document.getElementById('queue-close-time').innerText;
var timeDisplay = document.getElementById('queue-close-time');

window.setInterval(function() {
    document.querySelectorAll('[data-relative-from-timestamp]').forEach(function(element) {
        element.innerText = timeToGo(
            element.getAttribute('data-relative-from-timestamp'),
            element.getAttribute('data-display-long') === 'true',
        );
    });
}, 1000);

// Use ajax for "remove from queue" forms
document.addEventListener('submit',function(e){
    if(e.target && e.target.classList.contains('form-boot-seeker')){
        // Send a post request to the backend with the form data
        const xhr = new XMLHttpRequest();
        const formData = new FormData(e.target);
        xhr.open("POST", e.target.action);
        xhr.send( formData );

        e.preventDefault();
        e.stopPropagation();
        return false;
    }
});