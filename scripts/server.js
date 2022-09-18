// Asynchronous method of sending a request with authorization to the server
async function login(login, password) {
    let response = await fetch(
        `../app/api/user/login.php?login=${login}&password=${password}`,
        {
            method: "GET",
            headers: {
                "Content-Type": "application/json;charset=utf-8",
                "X-Requested-With": "XMLHttpRequest",
            },
        }
    );

    return await response.json();
}
// Asynchronous method of sending a request with registration to the server
async function register(login, password, email, name) {
    let response = await fetch(
        "../app/api/user/register.php",
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json;charset=utf-8",
                "X-Requested-With": "XMLHttpRequest",
            },
            body: JSON.stringify({
                login : login,
                password : password, 
                email : email,
                name : name
            })
        }
    );

    return await response.json();
}
