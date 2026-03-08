package main

import (
	"encoding/base64"
	"encoding/json"
	"fmt"
	"os"
	"regexp"

	"github.com/valyala/fasthttp"
	"github.com/valyala/fasthttp/prefork"
)

type Response struct {
	UserID string `json:"id"`
	Email  string `json:"email"`
	Code   string `json:"code"`
}

func main() {
	server := fasthttp.Server{}
	response := Response{}
	client := fasthttp.Client{}
	req := fasthttp.AcquireRequest()
	res := fasthttp.AcquireResponse()
	defer fasthttp.ReleaseRequest(req)
	defer fasthttp.ReleaseResponse(res)
	server.Handler = func(ctx *fasthttp.RequestCtx) {
		path := string(ctx.Path())
		bytes, err := base64.StdEncoding.DecodeString(path[1:])
		fmt.Println(path[1:], string(bytes))
		if err == nil {
			if err := json.Unmarshal(bytes, &response); err == nil {
				userID := response.UserID
				email := response.Email
				code := response.Code
				isValidUUID := regexp.MustCompile(`^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[1-8][0-9A-Fa-f]{3}-[ABab89][0-9A-Fa-f]{3}-[0-9A-Fa-f]{12}$`).MatchString(userID)
				isValidEmail := regexp.MustCompile(`^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$`).MatchString(email)
				isValidCode := regexp.MustCompile(`^\d{6}$`).MatchString(code)
				if isValidUUID && isValidEmail && isValidCode {
					ctx.Request.CopyTo(req)
					req.Header.SetMethod(fasthttp.MethodPost)
					req.SetRequestURI("http://php/verify")
					req.SetBodyString(fmt.Sprintf("id=%s&email=%s&code=%s", userID, email, code))
					req.Header.SetContentType("application/x-www-form-urlencoded")
					if err := client.Do(req, res); err == nil {
						res.CopyTo(&ctx.Response)
						return
					}
					ctx.Redirect("/login", fasthttp.StatusFound)
					return
				}
				ctx.Redirect("/login", fasthttp.StatusFound)
				return
			}
			ctx.Redirect("/login", fasthttp.StatusFound)
			return
		}
		ctx.Redirect("/login", fasthttp.StatusFound)
	}
	preforkServer := prefork.New(&server)
	if err := preforkServer.ListenAndServe(":80"); err != nil {
		fmt.Println(err)
		os.Exit(1)
	}
}
