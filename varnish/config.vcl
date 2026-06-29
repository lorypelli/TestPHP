vcl 4.1;

backend default {
    .host = "php";
}

sub vcl_backend_response {
    unset beresp.http.Pragma;
    unset beresp.http.Expires;
    set beresp.ttl = 15m;
    set beresp.grace = 75m;
}

sub vcl_recv {
    if (req.http.X-Auth == "1") {
        unset req.http.X-Auth;
    }
    if (req.url ~ "\.(css|js|png|ico)$") {
        unset req.http.Cookie;
    }
}