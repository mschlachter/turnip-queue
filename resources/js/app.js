require('./bootstrap');

document.addEventListener('submit',function(e){
   if(e.target && e.target.hasAttribute('data-confirm')){
        if(!confirm(e.target.getAttribute('data-confirm'))) {
        	e.preventDefault();
        	e.stopPropagation();
        	return false;
        }
    }
});
