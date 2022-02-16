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
