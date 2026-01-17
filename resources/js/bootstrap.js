import * as bootstrap from 'bootstrap';
import $ from 'jquery';
import axios from 'axios';

window.axios = axios;

window.bootstrap = bootstrap;

window.$ = window.jQuery = $;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
