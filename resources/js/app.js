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

document.addEventListener('click',function(e) {
    if(e.target && e.target.hasAttribute('data-dismiss') && e.target.getAttribute('data-dismiss') === 'alert'){
        var xmlHttp = new XMLHttpRequest();
	    xmlHttp.open("GET", meta('dismiss-notif-route') + '?id=' + e.target.getAttribute('data-notif-id'), true); // true for asynchronous
	    xmlHttp.send(null);
    }
});

// Our only jQuery usage so far..
$(document).on('close.bs.alert', function(e) {
    if(e.target && e.target.hasAttribute('data-notif-id')){
        var xmlHttp = new XMLHttpRequest();
	    xmlHttp.open("GET", meta('dismiss-notif-route') + '?id=' + e.target.getAttribute('data-notif-id'), true); // true for asynchronous
	    xmlHttp.send(null);
    }
});
