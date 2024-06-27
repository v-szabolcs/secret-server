# Secret Server Task

## Endpoints
| Route | Method | Description |
| :--- | :--- | :--- |
| /secret | POST (x-www-form-urlencoded) | Add new secret |
| /secret/{hash} | GET | Find secret by hash |

## Add New Secret - Payload
| Name | Type | Required |
| :--- | :--- | :--- |
| secret | string (max. 255 char) | yes |
| expireAfterViews | int (>0) | yes |
| expireAfter | int (>=0) | yes |

## Get Secret By Hash - Route Parameter
| Name | Type | Required |
| :--- | :--- | :--- |
| hash | string | yes |

## Response Based On Accept Header
| Format | Value |
| :--- | :--- |
| XML | application/xml |
| JSON (fallback) | application/json |
