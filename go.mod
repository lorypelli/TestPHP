module testphp-go

go 1.23.10

require github.com/valyala/fasthttp v1.69.0

require (
	github.com/andybalholm/brotli v1.2.0 // indirect
	github.com/klauspost/compress v1.18.4 // indirect
	github.com/valyala/bytebufferpool v1.0.0 // indirect
	golang.org/x/sys v0.41.0 // indirect
)

replace (
	github.com/valyala/fasthttp => github.com/valyala/fasthttp v1.65.0
	golang.org/x/sys => golang.org/x/sys v0.35.0
)
