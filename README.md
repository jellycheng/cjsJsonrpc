# cjsJsonrpc
cjs jsonrpc json rpc


###相关参考网站
http://www.jsonrpc.org/specification

### Install 
方式1：
```
composer require cjs/jsonrpc
```
方式2：
```
"require": {
	...,
	"cjs/jsonrpc": "dev-master"
	...,
}
```


```
请求:
{"jsonrpc": "2.0", "method": "foobar", "id": "1"}
响应失败:
{"jsonrpc": "2.0", "error": {"code": -32601, "message": "Method not found"}, "id": "1"}

请求:
{"jsonrpc": "2.0", "method": "getuserid4token", "params": {"token": "fdaidfbas123", "systemid": 42}, "id": 3}
响应成功:
{"jsonrpc": "2.0", "result": 19, "id": 3}

批量请求:
[
    {"jsonrpc": "2.0", "method": "User\\Profile.getinfo", "params": [1,2,4], "id": "1"},
    {"jsonrpc": "2.0", "method": "notify_hello", "params": [7]},
    {"jsonrpc": "2.0", "method": "subtract", "params": [42,23], "id": "2"},
    {"foo": "boo"},
    {"jsonrpc": "2.0", "method": "foo.get", "params": {"name": "myself"}, "id": "5"},
    {"jsonrpc": "2.0", "method": "get_data", "id": "9"}
]
批量响应:
[
    {"jsonrpc": "2.0", "result": 7, "id": "1"},
    {"jsonrpc": "2.0", "result": 19, "id": "2"},
    {"jsonrpc": "2.0", "error": {"code": -32600, "message": "Invalid Request"}, "id": null},
    {"jsonrpc": "2.0", "error": {"code": -32601, "message": "Method not found"}, "id": "5"},
    {"jsonrpc": "2.0", "result": ["hello", 5], "id": "9"}
]

```
