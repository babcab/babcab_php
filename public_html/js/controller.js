import 'core-js/stable'
import 'regenerator-runtime/runtime';

import Signup from './view/signup';
import Login from './view/login';
import Sidebar from './view/sidebar.js';
import tableUsers from './view/tableUsers';
import AddRide from './view/addRide';

const signupFormCont = document.getElementById("signup-form");
const loginFormCont = document.getElementById("login-form");
const sideNav = document.querySelector(".section-sidebar");
const tableUsercont = document.getElementById("table-users");

if (signupFormCont) {
    new Signup ('signup-form');
}

if (loginFormCont) {
    new Login ();
}

if (sideNav) {
    new Sidebar();
}

if (tableUsercont) new tableUsers();

if (document.querySelector(".section-addride")) new AddRide();
