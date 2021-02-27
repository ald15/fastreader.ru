let cookieInformerExpires = 7777600;

function acceptCookie () {
  document.cookie = 'cookieAccept=1;  max-age=' + cookieInformerExpires;
}

function getCookie (name) {
  let matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function addCookieAcception () {
acceptCookie();
closeCookieInformer();
}
if (!getCookie('cookieAccept')) {
  showCookieInformer();
}

function closeCookieInformer () {
  document.getElementById('cookieBlock').style = "display: none;";
}

function showCookieInformer () {
  document.getElementById('cookieBlock').style = "display: block;";
}
