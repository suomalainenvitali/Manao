//
//  REGISTER FORM UI LOGIC
//

let btn_form_register = document.getElementById("register_button-register");
let register_input_login = document.getElementById("register_input-login");
let register_input_password = document.getElementById("register_input-password");
let register_input_confirm_password = document.getElementById("register_input-confirm_password");
let register_input_email = document.getElementById("register_input-email");
let register_input_name = document.getElementById("register_input-name");
let register_login_help = document.getElementById("register_login-help");
let register_password_help = document.getElementById("register_password-help");
let register_confirm_password_help = document.getElementById("register_confirm_password-help");
let register_email_help = document.getElementById("register_email-help");
let register_name_help = document.getElementById("register_name-help");
let register_error = document.getElementById("register_error");

btn_form_register.removeAttribute("disabled");
// Event of the registration button on the registration form
btn_form_register.addEventListener("click", () => {
    if (registerFormValidate()) {
        register(
            register_input_login.value,
            register_input_password.value,
            register_input_email.value,
            register_input_name.value
        ).then((response) => {
            if (typeof response === "undefined") {
                registerErrorShow("Ошибка получения данных с сервера");
            } else if (response.status === "FAILED") {
                registerErrorShow(response.error);
            } else if (response.status === "SUCCESS") {
                registerErrorHide();
                registerClear();
                userAuthrize(response.data.login, response.data.name);
            }
        });
    }
});
// Processing of login input on registration form
register_input_login.addEventListener("input", () => {
    if (!register_login_help.classList.contains("d-none")) {
        register_login_help.classList.add("d-none");
    }
});
// Processing of password input on registration form
register_input_password.addEventListener("input", () => {
    if (!register_password_help.classList.contains("d-none")) {
        register_password_help.classList.add("d-none");
    }
});
// Processing of confirm password input on registration form
register_input_confirm_password.addEventListener("input", () => {
    if (!register_confirm_password_help.classList.contains("d-none")) {
        register_confirm_password_help.classList.add("d-none");
    }
});
// Processing of email input on registration form
register_input_email.addEventListener("input", () => {
    if (!register_email_help.classList.contains("d-none")) {
        register_email_help.classList.add("d-none");
    }
});
// Processing of name input on registration form
register_input_name.addEventListener("input", () => {
    if (!register_name_help.classList.contains("d-none")) {
        register_name_help.classList.add("d-none");
    }
});

// Checking validation of the registration form
function registerFormValidate() {
    let login = register_input_login.value;
    let password = register_input_password.value;
    let confirm_password = register_input_confirm_password.value;
    let email = register_input_email.value;
    let name = register_input_name.value;

    let count = 0;
    let validate = formValidate();

    if (validate.isLoginValid(login)) {
        count++;
    } else {
        register_login_help.classList.remove("d-none");
    }

    if (validate.isPasswordValid(password)) {
        count++;
    } else {
        register_password_help.classList.remove("d-none");
    }

    if (validate.isConfirmPasswordValid(password, confirm_password)) {
        count++;
    } else {
        register_confirm_password_help.classList.remove("d-none");
    }

    if (validate.isEmailValid(email)) {
        count++;
    } else {
        register_email_help.classList.remove("d-none");
    }

    if (validate.isNameValid(name)) {
        count++;
    } else {
        register_name_help.classList.remove("d-none");
    }

    if (count === 5) {
        return true;
    }

    return false;
}
// Show the Field of Errors on the Form of Registration
function registerErrorShow(error) {
    if (register_error.classList.contains("d-none")) {
        register_error.classList.remove("d-none");
    }
    register_error.innerText = error;
}
// Hiding the error field on the registration form
function registerErrorHide() {
    if (!register_error.classList.contains("d-none")) {
        register_error.classList.add("d-none");
        register_error.innerText = "";
    }
}
// Cleaning fields of registration form
function registerClear() {
    register_input_login.value = "";
    register_input_password.value = "";
    register_input_confirm_password.value = "";
    register_input_email.value = "";
    register_input_name.value = "";
}

//
//  LOGIN FORM UI LOGIC
//

let btn_form_autorize = document.getElementById("autorize_button-login");
let autorize_input_login = document.getElementById("autorize_input-login");
let autorize_input_password = document.getElementById("autorize_input-password");
let autorize_login_help = document.getElementById("autorize_login-help");
let autorize_password_help = document.getElementById("autorize_password-help");
let authorize_error = document.getElementById("authorize_error");

btn_form_autorize.removeAttribute("disabled");
// Authorization button on authorization form
btn_form_autorize.addEventListener("click", () => {
    if (loginFormValidate()) {
        login(autorize_input_login.value, autorize_input_password.value).then(
            (response) => {
                if (typeof response === "undefined") {
                    loginErrorShow("Ошибка получения данных с сервера");
                } else if (response.status === "FAILED") {
                    loginErrorShow(response.error);
                } else if (response.status === "SUCCESS") {
                    loginErrorHide();
                    loginClear();
                    userAuthrize(response.data.login, response.data.name);
                }
            }
        );
    }
});
// Processing of login input on authorization form
autorize_input_login.addEventListener("input", () => {
    if (!autorize_login_help.classList.contains("d-none")) {
        autorize_login_help.classList.add("d-none");
    }
});
// Processing of password input on authorization form
autorize_input_password.addEventListener("input", () => {
    if (!autorize_password_help.classList.contains("d-none")) {
        autorize_password_help.classList.add("d-none");
    }
});

// Checking validation of the regiauthorizationstration form
function loginFormValidate() {
    let login = autorize_input_login.value;
    let password = autorize_input_password.value;

    let count = 0;
    let validate = formValidate();

    if (validate.isLoginValid(login)) {
        count++;
    } else {
        autorize_login_help.classList.remove("d-none");
    }

    if (validate.isPasswordValid(password)) {
        count++;
    } else {
        autorize_password_help.classList.remove("d-none");
    }

    if (count === 2) {
        return true;
    }
    return false;
}
// Merchant display on the authorization form
function loginErrorShow(error) {
    if (authorize_error.classList.contains("d-none")) {
        authorize_error.classList.remove("d-none");
    }
    authorize_error.innerText = error;
}
// hiding fields with an error on the shape of authorization
function loginErrorHide() {
    if (!authorize_error.classList.contains("d-none")) {
        authorize_error.classList.add("d-none");
        authorize_error.innerText = "";
    }
}
// cleansing the fields on the form of authorization
function loginClear() {
    autorize_input_login.value = "";
    autorize_input_password.value = "";
}

//
//  AUTHRIZATION UI LOGIC
//

btn_login = document.getElementById("button-login");
btn_register = document.getElementById("button-register");
forms_section = document.getElementById("forms-section");
btn_exit = document.getElementById("button-exit");
header_user_div = document.getElementById("header-user");
header_login_div = document.getElementById("header-login");
user_name_div = document.getElementById("user-name");

// Login buttons event
btn_login.addEventListener("click", () => {
    showForm("form-login", "form-register");
});
// Register buttons event
btn_register.addEventListener("click", () => {
    showForm("form-register", "form-login");
});
// Exit buttons event
btn_exit.addEventListener("click", () => {
    deleteCookie("login");
    deleteCookie("name");
    authorize();
});

// Shows hides the forms of authorization/login
function showForm(form_show_id, form_hide_id) {
    if (forms_section.classList.contains("d-none")) {
        forms_section.classList.remove("d-none");
    }

    let form_show = document.getElementById(form_show_id);
    let form_hide = document.getElementById(form_hide_id);

    if (form_show.classList.contains("d-none")) {
        form_show.classList.remove("d-none");
    }
    if (!form_hide.classList.contains("d-none")) {
        form_hide.classList.add("d-none");
    }
}
// Authorization when loading the page using cookies
function authorize() {
    if (
        typeof getCookie("login") === "undefined" ||
        typeof getCookie("name") === "undefined"
    ) {
        if (header_login_div.classList.contains("d-none")) {
            header_login_div.classList.remove("d-none");
        }
        if (!header_user_div.classList.contains("d-none")) {
            header_user_div.classList.add("d-none");
        }
        user_name_div.innerText = "";
        return;
    }

    if (header_user_div.classList.contains("d-none")) {
        header_user_div.classList.remove("d-none");
    }
    if (!header_login_div.classList.contains("d-none")) {
        header_login_div.classList.add("d-none");
    }

    user_name_div.innerText = "Hello, " + getCookie("name");
}
// Authorization of the user in the system while preserving the cookies
function userAuthrize(login, name) {
    setCookie("login", login);
    setCookie("name", name);
    document.getElementById("forms-section").classList.add("d-none");
    authorize();
}

authorize();
