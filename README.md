# Secret Server Task

## Base URL
http://api.secretserver.nhely.hu/v1

## Endpoints
| Route | Method | Description |
| :--- | :--- | :--- |
| /secret | POST (x-www-form-urlencoded) | Add new secret |
| /secret/{hash} | GET | Get secret by hash |

## Add New Secret - Payload
| Name | Type | Required |
| :--- | :--- | :--- |
| secret | string | yes |
| expireAfterViews | int | yes |
| expireAfter | int | yes |

## Get Secret By Hash - Route Parameter
| Name | Type | Required |
| :--- | :--- | :--- |
| hash | string | yes |

## Response Based On Accept Header
| Format | Value |
| :--- | :--- |
| XML | application/xml |
| JSON | application/json |
