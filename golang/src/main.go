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

var (
	UUID_REGEX  = regexp.MustCompile(`^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[1-8][0-9A-Fa-f]{3}-[ABab89][0-9A-Fa-f]{3}-[0-9A-Fa-f]{12}$`)
	EMAIL_REGEX = regexp.MustCompile(`^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$`)
	CODE_REGEX  = regexp.MustCompile(`^\d{6}$`)
)

func main() {
	server := &fasthttp.Server{}
	client := &fasthttp.Client{}
	server.Handler = func(ctx *fasthttp.RequestCtx) {
		path := string(ctx.Path())
		bytes, err := base64.StdEncoding.DecodeString(path[1:])
		if err == nil {
			response := &Response{}
			if err := json.Unmarshal(bytes, response); err == nil {
				userID := response.UserID
				email := response.Email
				code := response.Code
				isValidUUID := UUID_REGEX.MatchString(userID)
				isValidEmail := EMAIL_REGEX.MatchString(email)
				isValidCode := CODE_REGEX.MatchString(code)
				if isValidUUID && isValidEmail && isValidCode {
					req := fasthttp.AcquireRequest()
					res := fasthttp.AcquireResponse()
					args := fasthttp.AcquireArgs()
					defer fasthttp.ReleaseRequest(req)
					defer fasthttp.ReleaseResponse(res)
					defer fasthttp.ReleaseArgs(args)
					ctx.Request.CopyTo(req)
					req.Header.SetMethod(fasthttp.MethodPost)
					req.SetRequestURI("http://php/verify")
					args.Set("id", userID)
					args.Set("email", email)
					args.Set("code", code)
					req.SetBodyString(args.String())
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
	preforkServer := prefork.New(server)
	preforkServer.Reuseport = true
	if err := preforkServer.ListenAndServe(":80"); err != nil {
		fmt.Println(err)
		os.Exit(1)
	}
}
