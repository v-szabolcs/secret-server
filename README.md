# Secret Server Task

## Base URL
http://api.example.com/v1

## Endpoints
| Route | Method | Description |
| :--- | :--- | :--- |
| /secret | POST (x-www-form-urlencoded) | Add new secret |
| /secret/{hash} | GET | Get secret by hash |

## Add New Secret - Parameters
| Name | Type | Required |
| :--- | :--- | :--- |
| secret | string | yes |
| expireAfterViews | int | yes |
| expireAfter | int | yes |

## Get Secret By Hash - Parameters
| Name | Type | Required |
| :--- | :--- | :--- |
| hash | string | yes |

## Response By Accept Header
| Format | Value |
| :--- | :--- |
| XML | application/xml |
| JSON | application/json |
