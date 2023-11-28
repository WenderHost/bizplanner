
/**
 * Sets a cookie.
 *
 * @param      {string}  cookieName      The cookie name
 * @param      {string}  cookieValue     The cookie value
 * @param      {number}  expirationDays  The expiration days
 */
function setCookie(cookieName, cookieValue, expirationDays) {
    // Calculate the expiration date
    const d = new Date();
    d.setTime(d.getTime() + (expirationDays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();

    // Set the cookie
    document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
}
// Usage example:
//setCookie("myCookie", "cookieValue", 365); // Set 'myCookie' with a value that expires in 365 days