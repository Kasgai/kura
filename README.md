# kura
The File Archiver for Kasgai System

## API Reference

### POST /
Responses 200.

#### Request
```
POST  HTTP/1.1
Host: kasgai-kura.herokuapp.com
Content-Type: application/json
Accept: */*
Cache-Control: no-cache
Accept-Encoding: gzip, deflate
Content-Length:*
Connection: keep-alive
cache-control: no-cache

{
    "html": "<html>...</html>"
}
```

#### Response
```
HTTP/1.1 200
Content-Disposition: attachment; filename=myPage.zip
Content-Type: application/zip
```
