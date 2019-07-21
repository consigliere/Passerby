# Passerby

- [Postman API Doc](https://documenter.getpostman.com/view/1015471/S1EH21nx)

- [API](#api)
    - [Refresh Token in Http Response](#refresh-token-in-http-response)
        - [Authenticate User](#authenticate-user)
            - [Http Request](#http-request)
            - [Http Response](#http-response)
        - [Refresh Token - Http Body](#refresh-token-http-body)
            - [Http Request](#http-request)
            - [Http Response](#http-response)
        - [Refresh Token - Query String](#refresh-token-query-string)
            - [Http Request](#http-request)
            - [Http Response](#http-response)
    - [Refresh Token in Http-Only Cookie](#refresh-token-in-http-only-cookie)
        - [Authenticate User](#authenticate-user)
            - [Http Request](#http-request)
            - [Http Response](#http-response)
        - [Refresh Token](#refresh-token)
            - [Http Request](#http-request)
            - [Http Response](#http-response)
    - [Logout User](#logout-user)
        - [Http Request](#http-request)
        - [Http Response](#http-response)
    - [API Tests](#api-tests)

## API

### Refresh Token in Http Response

Enable when `refreshToken.cookie.httpOnly` value in `config/password` set to _false_ - default value

#### Authenticate User

##### Http Request

```http
POST /api/login HTTP/1.1
Host: localhost:8000
Accept: application/vnd.api+json
Content-Type: application/vnd.api+json

{
	"username":"user",
	"password":"user"
}
```

##### Http Response

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU1NjFjYzQxYWFjZWExNGIyM2Y4YmY1OWJiYjgzNDVhNWJjNjU1NmRmZmIwZTY5OWYwZjc3NDA1ZTI2MzhiM2VkMDg5ZTFkMGVjYTU2ZmJhIn0.eyJhdWQiOiIyIiwianRpIjoiZTU2MWNjNDFhYWNlYTE0YjIzZjhiZjU5YmJiODM0NWE1YmM2NTU2ZGZmYjBlNjk5ZjBmNzc0MDVlMjYzOGIzZWQwODllMWQwZWNhNTZmYmEiLCJpYXQiOjE1NTc5ODAyNTQsIm5iZiI6MTU1Nzk4MDI1NCwiZXhwIjoxNTU3OTg3NDU0LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.IhRPM8DOGiqD9PG24-WHj14Dk0MA-kZjp8pf8t_yko6reZHd6PVzwOKGrntpZXfNhF8Ua-9C_gsD8JaxOXoRq5WKIwcq2XiuIa1sNiuYjRtGHX9kbgczkSYkbmNTUlHvt-GQTADh5v3HwnWUlTKOr_qZUaoHaCg1ymA2hkvXWhDSvAkc4htYeWG38RgQRISDmhXAyUkO3yF8zCuNP_UtRpJDT12pGx9FW0gEJWEXOr4X-0U91CJ4GGBy3Z4Igpy-AyFivB7Zk5grtTvvpDJc_QiKi6UToDiSIDce0Nnyhu9jpC3Lgof64ah70TEW1BwyWtPGgwI7BFg27jAbq6GLwr_-fF-_cwWF9mA21HeePU7q25Lsxr-SflujL_CvcfnKBpilmpbXTuGUTAmF-9fpePY06U73rKGa9K8rlewaze3Kkf_NSG2R0LrcFKeJrKdwrNdqmxeS8Va1Lbp3CCn_sLL-WML1lQOuI9rHgoAT6QjSw_gxIldPmPAqEkAh5aagdI00YMvSAP03OVxtllLHSR0gDAuJk-EgNaDCBy4uxq2I8xiJbPdN6KKeCpjepSGsQ1YYNkodwcNh4P5MaHVahAF26VYN8quo0dXxMQ65XxGw6Xyf2NquM0PCQTnN39q6YxsNbHOpyBB9lHJk0vG-uugjo0icRW8Is2eyiDYMbsA",
    "refresh_token": "def5020085e818b57ce4820d959a3bd7160ab7460496d27be368821d0179033f763ff13fe5975c5888d98b50d7400a67aef4bda18f76c3042b34ac05080de4af9b162fc27227b5795546d74e91580b6420520b6919d3ec6d26240e8b85325f1e9843aa6d3a3c0477530b22338a4b5208c1a97f7f265acaabfaf3644daa01f6d691111f4d89374c518a36138f1e5fc80a87d41a880ac59a4999d4ed4831245d640d7142984d4f50229467b7614141116f1cf297cf13a2294ad3ab486e6cc6be2958abab70fcac627dabbe3c3f73a363de1843655bf1937f4afd6b7539ce694c9a9011bad97830bd8134966db489f9280b7cdc030b116ffcae8201fc887fa3e8f2ddfa7db507019521b94dd24fefcfac60c6cbc76cdee40b0d6869b642bc48b9168c98a63007cb85b4eabd8f1e68cb72ff764033cd9bb54df393e84fde9215a275d17af858723344b81dee097a25755feedba43ddffb595641c40907da3d761acce1",
    "expires_in": 7200
}
```

#### Refresh Token - Http Body

##### Http Request

```http
POST /api/login/refresh HTTP/1.1
Host: localhost:8000
Accept: application/vnd.api+json
Content-Type: application/vnd.api+json

{
    "refreshToken":"def50200b18fa90ea8c0ff00f6cf49fa5240aa4eb11131c349e4c3fe5b072443eed8283bebd504ff496bd4835a31efed77dcdec47d971149626626e6003e07d76c6dab8049979c0d9760aab0216b91db71d94d2cdd1ede44007e2feb8e43812f4418a5e308a9a9f0865d016f93e8f333f75a3ffc6a640effa2d1d52a743c08d282ad47870b1152df18e4070cd260219cb11df058c9bf9eaff137a73ff257cf747dfb7a7400eb2c7dd39b626503aadaad2f192c2d5938f7fc271ef7bab99f07681f8abaab1b47afbb66b068817ac45b8e41077b5644d9be28305a27292dd7aab8cb080e8f781c0f0ecdd70a3c92c1ec99f4d3b7b2f0339648acc91dfc7d70efb3e550d07eadb5c459b5129b9e834a57bb0e380b3ed2112722a33ed78d763722c81a8a68c9ef2aff10cf146101084eee18a8bbf8851e6bee085bb0c0c6cb9a47ef70257deb11d93aede1cf6c0cd97d27e626c749e739062408c99acb828bbb95e61e"
}
```

##### Http Response

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBlZjE3YTBlZGVhNTJlMjhhYTBiZGU2NjFhMmJhNjAwMDkxOTA1YjgwZTA1NWQ2MmY5MWViMjFmYTNiOWM2ZTAxZTZiNTllMTBlZTVjNDg4In0.eyJhdWQiOiIyIiwianRpIjoiMGVmMTdhMGVkZWE1MmUyOGFhMGJkZTY2MWEyYmE2MDAwOTE5MDViODBlMDU1ZDYyZjkxZWIyMWZhM2I5YzZlMDFlNmI1OWUxMGVlNWM0ODgiLCJpYXQiOjE1NjMxNjA3NzQsIm5iZiI6MTU2MzE2MDc3NCwiZXhwIjoxNTYzMTYxMzc0LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.YSPefsWCdcbcSaG2JZTHcQTUvWs9OmU1wqnOTj8ctiHtya9n2PALgEZ5YHwBAIpnUB1YtcE5tg7VW7Rtc1XozbQkcc4ielfmamzAcR1ygWdaVSHOC03xKleuazcYdoJr-5ZMjRUpA-aicj4EXjWqFzUgZLd0fTgzUMPXOdLRaaj9SMVZaQWboZRiSIdo4lKelekRKxY1qY0R6VPG9N9fJhq-l494xQJpx1JPacqEH6CNHiYywtGUq7HN6f9IWSd0f5R_wNdCbitE7H6JWTfd36JUqW4bgs3YlM0DJEd3ExRebEdeglWEpb-eEOpRjyUuMpCQcydnjmJIEgQtmY-KvGBx_A-PWebp0JqUuxnk9kOrPP2k1MGNnCYJUkgEMiC73EFNaAYZkRpkcckTabsgUQE7WwFKDVVCXV8uWIETTkkpsMbtJawSbo6bXH6s5i7RiVGz4hJk5dCR5BI47dhZpdXEcWG89AZnMiRSDG5QcYKY1x6uyPyJqUuaSNQAeDOloj7ftRWvD4cEvlzj5dfYzP8I9T8aVOKKfkhYm2xUiqhsxJnjvf5WT-VXZAiwXp6Vxo5dFD-FNx6HMqH8hECraVSyu0K8Y_AsLcztyZ577IIMbQVEOea0-ZBjNh9gEekyz6N7CRULJjs74gp1Zzuym9PRg1zo4fKjg5YDrOceBWI",
    "refresh_token": "def50200eeb78ca69893af21b524737b2c84db47ca05c12ad2f97a860e4add13ad22e3d8bfe08a6b003017dd034dece06ecfeeac93a4dfb1af7e226133ee755507a110e5399e0c3e93cc2eda93f72583898d37c6dc5404147e4c1ab0140b028d90c4d1a3fce296bfa7b70999cd5bcc99423a539f67932fb8cb9b9a59514e11743657b125c72180832ad97b7c25b34245867cb02f4546b9b04f76f27eab12c9e59772438e99eeeddab5d06ddb0bedd164d5ca2da53cb2f768a99836b4b4cf7d504593aa74da4531d45fa2a3e5fb3c1148414ebc6497e610f3562b9a5015999244c4bc2f1c21abd7f6a9bc8847ad836edcf9e1f92fc2ab56f74ab1b92edf90c5ca4d0df5d5fc5082e90f4822a2009716db635d742858c970ef652467ed582473a4ff765947c4c40ff62440359f0583f19d51bea18e5309be60e902c8e0bd388d40f30ee3056ea3bbaa0b881f7fcd46af42a65dacfaa01030f4e6b8902c9b22caf09f",
    "expires_in": 600
}
```

#### Refresh Token - Query String

##### Http Request

```http
POST /api/login/refresh?refreshToken=def502006320a539f572b90591cd91531d6ebc2552d18c01a51f626e14437c1b404824d61675e77a9cb3fdf7e10bac030d6741faf64c75a2dec495a823e3ce1182eb930024e2c2ee28f2c22caaf150ec73d746b42677053617a61aa91c0b43d062d6ffd124ca1c7831ad5345f0358089f2a69887821eced19d0400083175fa1a32b75a61643a82a94c17ac5f16ba5c279e00eee0106629c67fbbbd647ab73f3755a0314bef81592242089ce30f65e361a3bf9c477104c1840d9a0fb4379107a7371669e765dcb0ed62c916c33785d86e120dc531ea43c13dc698bc57848c09f4e0f77761920c35da18c1015d41b0e822b9688afce75d947ac639bae88035f26f7a1926623bca68bbb6bf7bc5a3cac45e2039ea2a0354b40b2166a1acbb3471c52d019825bd97b26564e7a92933224d521c8290b22938c1feaee98460aa6b06fd252bd39132c134fdc5732fba4c4e312bc27f30329540feaafee7c501acb6024f22 HTTP/1.1
Host: localhost:8000
Accept: application/vnd.api+json
```

##### Http Response

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImE0OWRiOWE5OTZiZWM2ZDIwZTIyYmVkMTRlYmZhYTZkNjQ1ZTA0NjI4NDdiNjE3ZmJiNWM0ZDcxNjdhZWQ5MGUzMTE4NDVlZDQxZjk2Zjc1In0.eyJhdWQiOiIyIiwianRpIjoiYTQ5ZGI5YTk5NmJlYzZkMjBlMjJiZWQxNGViZmFhNmQ2NDVlMDQ2Mjg0N2I2MTdmYmI1YzRkNzE2N2FlZDkwZTMxMTg0NWVkNDFmOTZmNzUiLCJpYXQiOjE1NjMxNjA2NDAsIm5iZiI6MTU2MzE2MDY0MCwiZXhwIjoxNTYzMTYxMjM5LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.r1w675wU_wof2Tn-eiOryXjdK81hWXfXqCPUY6EnwVEqAdyZeiaTcQIZB8Nh8bRQiUQEyKSG-UltKQLhajgEnoJ_8H2UqWSquhIUBcXe91NJXVLYnuODUZAXtJSsCCKMcHZqP4VRXDs7ZMaEso44tLHzlmTH4daPMDJMwuCrv20QmN3NKi-P_XISC77df6p1xSBTTRAw7VZSgxxNfnlyc_30RtvVRnLG2aNq5Qc3upfRIzjrqWiGrbzGnrWTMR4WAOS283STUz9ZtwEYAzschuLM4XM_pFckonespub1z24wNv41olnJF6ADoL3Z2fDJeFulkEZugCDQwl5ca1t9YwCDxpSn-zfY_QZ5YPinrFGwxliXZk1ZzO5iNpXHGKMwsnGCZc3s60TunyJaBjwgd6EFhiABquyjHvQ5QYSGaJXXz3FKhtsjCK144kdseWapAYp00QTp8CkGkqZNLRcP14w98cVyDeHic0gEQwK1IYPoMFPA0RGsDs8fRZoR88qitBl3l-Dz4f3JPc7fUkcxL-wc9-FxPP2WaEuwKflxdMZSSlv0dQKt_EgC_BxEnhEJ8eUh3_CAM21P3wntfSpoqBnnDjXPw-LN2CVPLovonExsJHGgDCb9sIqNQv_rkih7KKnEoMxMNESD40qwrtlNpKOqUj_nJRE1d3hVppBoY0U",
    "refresh_token": "def50200b18fa90ea8c0ff00f6cf49fa5240aa4eb11131c349e4c3fe5b072443eed8283bebd504ff496bd4835a31efed77dcdec47d971149626626e6003e07d76c6dab8049979c0d9760aab0216b91db71d94d2cdd1ede44007e2feb8e43812f4418a5e308a9a9f0865d016f93e8f333f75a3ffc6a640effa2d1d52a743c08d282ad47870b1152df18e4070cd260219cb11df058c9bf9eaff137a73ff257cf747dfb7a7400eb2c7dd39b626503aadaad2f192c2d5938f7fc271ef7bab99f07681f8abaab1b47afbb66b068817ac45b8e41077b5644d9be28305a27292dd7aab8cb080e8f781c0f0ecdd70a3c92c1ec99f4d3b7b2f0339648acc91dfc7d70efb3e550d07eadb5c459b5129b9e834a57bb0e380b3ed2112722a33ed78d763722c81a8a68c9ef2aff10cf146101084eee18a8bbf8851e6bee085bb0c0c6cb9a47ef70257deb11d93aede1cf6c0cd97d27e626c749e739062408c99acb828bbb95e61e",
    "expires_in": 599
}
```

### Refresh Token in Http-Only Cookie

Enable when `refreshToken.cookie.httpOnly` value in `config/password` set to _true_

#### Authenticate User

##### Http Request

```http
POST /api/login HTTP/1.1
Host: localhost:8000
Accept: application/vnd.api+json
Content-Type: application/vnd.api+json

{
	"username":"user",
	"password":"user"
}
```

##### Http Response

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjY5MzIxMzc4MzNhOGYzMjFmZmYwMWNmNDU4ODNmMWM5NWEyNWFmN2QwMmZkNmQ3MzdkMTEyNzI5NzdiNDlhN2Q4NzM1MzU5MjVkNTNjMzRjIn0.eyJhdWQiOiIyIiwianRpIjoiNjkzMjEzNzgzM2E4ZjMyMWZmZjAxY2Y0NTg4M2YxYzk1YTI1YWY3ZDAyZmQ2ZDczN2QxMTI3Mjk3N2I0OWE3ZDg3MzUzNTkyNWQ1M2MzNGMiLCJpYXQiOjE1NjMxNTk5NTMsIm5iZiI6MTU2MzE1OTk1MywiZXhwIjoxNTYzMTYwNTUzLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.he4oQNrcUCIgmkDKO_SSUfqpEMSTkCR6AVDLJRXI4acrDi6DVP8vMSkH6VfuNENt9TqNnYgQdU9msZD7Iwzbj0_zmBykWQpBFEESiiNSl7IWoFgwQdvXrrAChClSeH_CNKA5OzeIBv4H4IcSvK_lDnrVxB7bfsqMpStnq0TjdlUlgJfhBhlIl3qqt0sTiEO8M4txeCnmHCMSJGsZoywDc18lmYe0FofwVc6EYmKHhfoD-JVR6MQ2nhxjUxeCfvlbY4K72BIHeWnGqYOOz4NkPHcSukDlXh0T_imPQsToXVKHKY7Dzbgig_clWrXcUJ2kwiz_DQyB-nVT-6g6JZbG6uU55ft2eUo4DRAf12iwnJrDelHtlrK5BHv1oAp4j7seOJa77JKdqn5JF6VAL56YmM8jdnZByn4Ef7MhajFID-yGFtZFsBBJBv4xB3W9RbKEVxLvXsPL0CpGWEv5383T8Wi6Ca3RgKFDDbSG_e5zLS4tlVM-j4u_vEKu_HZHG2fWFxYForhoTJSRuzzhl0mLe4Y5e3E_42EvgovqWDGqDFF77O-vXzNPVb3HepRE6lCZE9OEJEuW73ZX_1UWhHCSTNgRbTUJNvIVNXx2PlvDH38M7nRqrds9Mh93NaRcrcCiGDNpAdt7fVgsak2ni1oi63mcZNVvspmFJPeBFghBg_o",
    "expires_in": 600
}
```

#### Refresh Token

##### Http Request

```http
POST /api/login/refresh HTTP/1.1
Host: localhost:8000
Accept: application/vnd.api+json
```

##### Http Response

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ0YWE3Yzg2NTMwNmY0NDkxMDI5MjA3YWQ2NDk1ZTMyNGE0ZTU1MzI1MDNhNjhjMDZmZDM4M2JjZWU4ZDNkN2Y5MTFhMDVhM2Q2NmZhMzI5In0.eyJhdWQiOiIyIiwianRpIjoiZDRhYTdjODY1MzA2ZjQ0OTEwMjkyMDdhZDY0OTVlMzI0YTRlNTUzMjUwM2E2OGMwNmZkMzgzYmNlZThkM2Q3ZjkxMWEwNWEzZDY2ZmEzMjkiLCJpYXQiOjE1NjMxNTk5OTIsIm5iZiI6MTU2MzE1OTk5MiwiZXhwIjoxNTYzMTYwNTkyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.pQaRWeF7Oz4lccMU7crT2SuVG15bbZ3K2g1VWhOHkaJXJC2MG36awqzFn_JPkfnN3kpv2fej8OgISnDDbbf-mC3sJ4qRpr4mIgcSfmpsgzWSpnu4juBQ7cPfTSVn-e9Bwvry0T1hgwlee2Z450gOB0EmACE5bAIu_wck1Hq4NhKxxoaTKzlfJMFVBP7up5Ny2UtcrERkDwD7Yap7EbY-Zq9eehDOHsGWRt0wEzt41_ql5MqcK4Ww6gBHIdhToW_KN1La5YvrEPB9fe071KwccWlLdpv88ZS5GmmEY8qschcNQMxcgHZLjWvJZde--6ae234yIas6sLzsVMTqasH3JSL_LltCB52ncEt6CKP4VY_oyE5GpKzoO6oUJRj40WKWZ9vTCIFsvtFLx-GWKDKAg-0KA8OZmSNQyQRJIioqeVnxFoJ06aTKglgN0JxoCeWmDL6uxQLaK10NOce_fTibYSZo5keBQWkbxNo6yG6he4zO1sum8tByzhua9TdTDBxYbBNPDhFFune2nKpf2Ux9tzVVezLskuj9OTIPRTr2kZmH2Rdr7U7rE_nQl37XmUg-MYWNHV51JeI4sHuJHJzSd72_rTHw2YwjHIijw6yw8eH_Z9qUQRsSp4A0nHVCukqC0ZilrZljZhYTIqrLWjoW2jPK_TQGjdbxqELB_U_nm40",
    "expires_in": 600
}
```

### Logout User

#### Http Request

```http
POST /api/logout HTTP/1.1
Host: localhost:8000
Accept: application/vnd.api+json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU5Mjg2Nzg1MGU0YjA5ZDA0YzFhZDlmNzRiNTRlOTk2OGQxOWY3OWE4ZjMxMTVmZmFmNGUxMWQwMjJlYWMwMGU1MTJhNWM4MjMwY2Q5NDM1In0.eyJhdWQiOiIyIiwianRpIjoiZTkyODY3ODUwZTRiMDlkMDRjMWFkOWY3NGI1NGU5OTY4ZDE5Zjc5YThmMzExNWZmYWY0ZTExZDAyMmVhYzAwZTUxMmE1YzgyMzBjZDk0MzUiLCJpYXQiOjE1NjMxNjAxODQsIm5iZiI6MTU2MzE2MDE4NCwiZXhwIjoxNTYzMTYwNzgzLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.m5YW72JVik95Tdqvt1l8kghlMf4RysblWw-dzwzafMZjmz-vxXeqboSS6MIbb6n_mWfbDxZ_3yAvqv5mUZxRSV2eXg-Fw_kOBdgwOn95gD1PEsarDT4haU0BC_u1Y5f5IzOfY6Tkh_Z4y5RNTkDd5H4zEYYZNoFPYKQWUvZibxQTYJ3fPVOLTZ_te_xJJ4jMD-l6POzZCvZvBE5OL7bxIcqEGjwFVjabrTD6iXpAL1HYh4bnj6325TqSipcN7d74OoKH7EGR-D6aLk4Q18O47gA3q4tK0c9QKeZYJCeZ9NQ5TsUTo2StEt0nruJRcg4Fg7BuMOJnPdwHG2F_vvxIM8ptBHgH6tzRrY2ai_RRjIhiZu8QGM1cxQbwSq62Fct9XtuegFpM8Vye2oFLFmgEQkWHDN684jSg15EVokTkc_utL7kEGP9lVKcSSmOk6-iXOxapTLeUYqB08QWEx7VCl9IdZezuVBHSKF5O1yx87hDkkV2GW7qHRskdT-faMA7UpqadMCZgbVgyj8zbL7sP8jaXdPzb8vCIYFIjDSJQqBkE4BxyQmz_0sxMgRqBxze-h0gf9CxbR1tEYGigkZy3myVhqGxWalnkwF4FkUsPGMA3aFq5mtrNQTD0UaC-_OkUqMP6ZYiCDuqNXN_9LDd4ZWgmgmd1NCXlWS2G6uZAGoE
```

#### Http Response

```json

```

Notes:
- Success response will return http status `204 No Content`

### API Tests

All API test file extend from `PasswordApiTestCase`.

```php
namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

/**
 * Class PasswordApiTestCase
 * @package Tests
 */
abstract class PasswordApiTestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function init(): void
    {
        Passport::actingAs(
            factory(\Api\User\Entities\User::class)->create(['uuid' => randomUuid(), 'username' => 'test' . mt_rand()])
        );
    }
}
```

#### Publish Tests File

```bash
php artisan vendor:publish --tag=password_tests --force
```

#### Run PhpUnit

```bash
phpunit
```
