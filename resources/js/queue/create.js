var durationSlider = document.getElementById("duration");
var durationOutput = document.getElementById("duration-display");
durationOutput.innerHTML = durationSlider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
durationSlider.oninput = function() {
  durationOutput.innerHTML = this.value;
} 

var visitorSlider = document.getElementById("visitors");
var visitorOutput = document.getElementById("visitors-display");
visitorOutput.innerHTML = visitorSlider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
visitorSlider.oninput = function() {
  visitorOutput.innerHTML = this.value;
}