require('./bootstrap');

document.addEventListener('submit',function(e) {
    if(e.target && e.target.hasAttribute('data-confirm')){
        if(!confirm(e.target.getAttribute('data-confirm'))) {
        	e.preventDefault();
        	e.stopPropagation();
        	return false;
        }
    }
});

// Persist notification dismiss via session
function persistNotificationDismiss (e) {
    if(e.target && e.target.hasAttribute('data-notif-id')){
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET", meta('dismiss-notif-route') + '?id=' + e.target.getAttribute('data-notif-id'), true); // true for asynchronous
        xmlHttp.send(null);
    }
}

for(element of document.getElementsByClassName('alert')) {
    element.addEventListener('close.bs.alert', persistNotificationDismiss);
};

// Detect a notification-related event
var notificationChannel = Echo.channel('App.SiteNotification');

notificationChannel.listen('SiteNotificationAdded', function(e) {
    var notificationInfo = e.siteNotification;

    var notification = document.createElement('div');
    notification.classList.add('alert');
    notification.classList.add('alert-' + notificationInfo.type);
    notification.classList.add('mt-4');
    notification.classList.add('mb-0');
    notification.classList.add('show');
    notification.setAttribute('data-notif-id', notificationInfo.id);

    notification.innerHTML = '<svg style="width:1rem;vertical-align: -0.125em;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="exclamation-triangle" class="svg-inline--fa fa-exclamation-triangle fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path></svg> ';

    var messageText = document.createElement('span');
    messageText.classList.add('message-text');
    messageText.innerText = notificationInfo.message;
    notification.appendChild(messageText);

    var closeButton = document.createElement('button');
    closeButton.type = 'button';
    closeButton.classList.add('close');
    closeButton.setAttribute('data-dismiss', 'alert');
    closeButton.setAttribute('aria-label', 'Close');
    notification.appendChild(closeButton);

    var closeIcon = document.createElement('span');
    closeIcon.setAttribute('aria-hidden', 'true');
    closeIcon.innerHTML = '&times;';
    closeButton.appendChild(closeIcon);

    document.getElementById('site-notification-holder').appendChild(notification);

    new BSN.Alert(notification);
    notification.addEventListener('close.bs.alert', persistNotificationDismiss);
});
notificationChannel.listen('SiteNotificationRemoved', function(e) {
    document.querySelector('[data-notif-id="' + e.siteNotification.id + '"]').remove();
});
notificationChannel.listen('SiteNotificationUpdated', function(e) {
    var notification = document.querySelector('[data-notif-id="' + e.siteNotification.id + '"]');
    notification.querySelector('.message-text').innerText = e.siteNotification.message;
    notification.classList.remove('alert-success');
    notification.classList.remove('alert-warning');
    notification.classList.remove('alert-danger');
    notification.classList.remove('alert-info');
    notification.classList.add('alert-' + e.siteNotification.type);
});