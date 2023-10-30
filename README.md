
# Laravel-backend-test

## API Reference

#### Login 


```http
  POST /api/login/
```


| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email`      | `string` | Required |
| `password` | `string` | Required |


#### Add new orgnasation

```http
  POST /api/organisation/
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | Required |
| `owner_user_id` | `number` | Required |

    {
        data: {
            organisation: {
            id: 181,
            name: sxdegsndsfjmjxd45,
            owner_user_id: 2,
            trial_end: 2023-11-27 11:52:34,
            trial_start_timestamp: 1698493954,
            trial_end_timestamp: 1701085954,
            subscribed: 1,
            created_at: 2023-10-28T11:52:34.000000Z,
            updated_at: 2023-10-28T11:52:34.000000Z,
            owner: {
                id: 2,
                name: Vernie Powlowski Jr.,
                email: bonipo1243@zamaneta.com
            }
        }
}

#### Get all orgnazations

```http
  GET /api/organisation/
```


| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `filter`      | `string` | Filters are optional. Example. `trail`, `subbed`, `all` |

    {    
      data : {
                organisation: [
                    {
                        id: 1,
                        name: Gibson-Bartell,
                        owner_user_id: 1,
                        trial_end: 2023-11-20 10:36:03,
                        trial_start_timestamp: 1697884563,
                        trial_end_timestamp: 1700476563,
                        subscribed: 1,
                        created_at: 2023-10-21T10:36:03.000000Z,
                        updated_at: 2023-10-21T10:36:03.000000Z,
                        owner: {
                        id: 1,
                        name: Bud Mann,
                        email: oswaldo97@example.org
                        }
                    },
                    {
                        id: 172,
                        name: sxwsdwwerxsdsfxd45,
                        owner_user_id: 2,
                        trial_end: 2023-11-27 09:42:47,
                        trial_start_timestamp: 1698486167,
                        trial_end_timestamp: 1701078167,
                        subscribed: 1,
                        created_at: 2023-10-28T09:42:47.000000Z,
                        updated_at: 2023-10-28T09:42:47.000000Z,
                        owner: {
                            id: 2,
                            name: Vernie Powlowski Jr.,
                            email: bonipo1243@zamaneta.com
                        }
                    }
                ]
            }
    }
