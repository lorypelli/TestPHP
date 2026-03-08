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
	id    string
	email string
	code  string
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
		if err == nil {
			if err := json.Unmarshal(bytes, &response); err != nil {
				isValidUUID := regexp.MustCompile(`^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[1-8][0-9A-Fa-f]{3}-[ABab89][0-9A-Fa-f]{3}-[0-9A-Fa-f]{12}$`).MatchString(response.code)
				isValidEmail := regexp.MustCompile(`^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$`).MatchString(response.email)
				isValidCode := regexp.MustCompile(`^\d{6}$`).MatchString(response.code)
				if isValidUUID && isValidEmail && isValidCode {
					ctx.Request.CopyTo(req)
					req.Header.SetMethod(fasthttp.MethodPost)
					req.SetRequestURI("http://php/verify")
					req.SetBodyString(fmt.Sprintf("user_id=%s&email=%s&code=%s", response.id, response.email, response.code))
					req.Header.SetContentType("application/x-www-form-urlencoded")
					if err := client.Do(req, res); err == nil {
						res.CopyTo(&ctx.Response)
						return
					}
					ctx.Error("Bad Request!", fasthttp.StatusBadRequest)
					return
				}
				ctx.Error("Bad Request!", fasthttp.StatusBadRequest)
				return
			}
			ctx.Error("Bad Request!", fasthttp.StatusBadRequest)
			return
		}
		ctx.Error("Bad Request!", fasthttp.StatusBadRequest)
	}
	preforkServer := prefork.New(&server)
	if err := preforkServer.ListenAndServe(":80"); err != nil {
		fmt.Println(err)
		os.Exit(1)
	}
}
