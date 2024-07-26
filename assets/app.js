import './bootstrap.js';
import './styles/app.scss';
import { startStimulusApp } from '@symfony/stimulus-bridge';

import '@symfony/ux-chartjs';
import 'chartjs-adapter-date-fns';

// Import jQuery
import $ from 'jquery';
// Import Bootstrap's JS
import 'bootstrap';


$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
