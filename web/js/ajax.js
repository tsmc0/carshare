const LOGIN_ACTION = 'site/login';
const LOGIN_ACTION_PASSWORD = 'login-password';
const GET_MODELS = 'get-models';
const ADD_AUTO = 'add-car';
const CAR_INFO = 'car-info';
const WRITE_RENT = 'write-rent';
const PROFILE_UPDATE = 'profile';
const CREATE_GROUP = 'create-group';
const ACCEPT_INVITE = 'accept-invite';
const GROUP_INFO = 'group-info';


function bindFormSend(formDescription, callback) {
    sendRequest(formDescription.url, formDescription.params).then((res) => callback(res))
}

function sendRequest(url, params) {
    return fetch(url, params).then((res) => res.json())
}

function gid(elemID) {
    return document.getElementById(elemID)
}

function redirect(to) {
    window.location.href = to;
}

function getParentNode(element) {
    return element.parentNode;
}