"use strict"; // Start of use strict

import 'bootstrap';

import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

const run = function() {

};

document.addEventListener('DOMContentLoaded', function() {
    if (document.readyState === 'interactive' || document.readyState === 'complete') {
		return run();
	}
}, false);
