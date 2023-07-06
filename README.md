
# API Security Hackathon by Treblle
## Introduction
This project is submitted to [API Security hackthon 2K23](https://blog.treblle.com/api-security-hackathon/) conducted by [trebble](https://www.treblle.com/)




## Deployment

### Prerequisites

- PHP (version >= 8.1)
- Composer (https://getcomposer.org/)
- Laravel (https://laravel.com/)
- MySQL (or any other supported database)
- Git

### Installation

Clone the project repository from GitHub (or extract the project files if you have a zip archive).

```bash
git clone https://github.com/Bhuvi100/treblle-hacko.git
```

Navigate to the project directory.
```bash
cd trebble-hacko
```

Install project dependencies using Composer.
```bash
composer install
```

Copy the .env.example file and rename it to .env and configure the .env file.
```bash
cp .env.example .env
```

Generate the application key.
```bash
php artisan key:generate
```

Run the database migrations.
```bash
php artisan migrate
```

Start the local development server.
```bash
php artisan serve
```
Server will be started on :

```sh
localhost:8000
```




## API Reference
#### Customer login
```http
POST api/v1/auth/login
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | Name of the user |
| `email` | `string` | Email id of the user  |
| `password` | `string` | password for the email handel  |
| `password_confirmation` | `string` | Retyped password |

`Response`
| Status Code | Structure | Example |
| ---------- |--------- | ------ |
| 200 | { <br> status: string , <br> token: string, <br> user: <br> user object <br>} | {<br>status: "success",<br>token: "3\|TNc0pHeT9AdQjlTjHiRBKy7ksxqFFV2lCaahuC6T",<br>user: {<br> id: 2, <br>name: "user-1",<br>email: "test1@2test.com",<br>email_verified_at: null,<br>created_at: "2023-07-06T09:55:38.000000Z",<br>updated_at: "2023-07-06T09:55:38.000000Z"<br>}<br>} |

#### Admin login
```http
POST api/v1/admin/auth/login
```
| Parameter                | Type     | Description                    |
| :----------------------- | :------- | :----------------------------- |
| `name`                   | `string` | Name of the admin              |
| `email`                  | `string` | Email ID of the admin          |
| `password`               | `string` | Password for the admin         |
| `password_confirmation`  | `string` | Retyped password               |

`Response`
| Status Code | Structure                    | Example             |
| ----------- | ------------- | ------------------- |
| 200         | {<br>status: string,<br>token: string,<br>user: user object<br>}                                      | {<br>status: "success",<br>token: "6\|q9ZORbMOAxiTnQC2ebw82hco336kHl4xaZhy5vKJ",<br>user: {<br>&nbsp;&nbsp;&nbsp;&nbsp;id: 1,<br>&nbsp;&nbsp;&nbsp;&nbsp;name: "user-1",<br>&nbsp;&nbsp;&nbsp;&nbsp;email: "test1@test.com",<br>&nbsp;&nbsp;&nbsp;&nbsp;email_verified_at: null,<br>&nbsp;&nbsp;&nbsp;&nbsp;created_at: "2023-07-06T09:45:39.000000Z",<br>&nbsp;&nbsp;&nbsp;&nbsp;updated_at: "2023-07-06T09:45:39.000000Z"<br>}<br>} |


#### Customer registration

```http
POST api/v1/auth/register
```


| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | Name of the user |
| `email` | `string` | Email id of the user  |
| `password` | `string` | password for the email handel  |
| `password_confirmation` | `string` | Retyped password |

`Response`
| Status Code | Structure        | Example      |
| ----------- | ------- | ---------------------- |
| 200         | {<br>status: string,<br>token: string,<br>user: user object<br>} | {<br>status: "success",<br>token: "2\|QwAyRpsnIJCO5FqrVWIVh6YVkg <br>} |

#### Customer account

```http
GET api/v1/user
```
| Auth | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Auth Key` | Bearer Token | Response of token that is returned by login |

`Response`
| Status Code | Structure | Example |
| ---------- |--------- | ------ |
| 200 | { <br> data: <br> "user object" <br>} | { <br>data: { <br>id: 1, <br>name: "user-1",<br>email: "test1@test.com",<br>email_verified_at: null,<br>created_at: "2023-07-06T09:45:39.000000Z",<br>updated_at: "2023-07-06T09:45:39.000000Z",<br>is_admin: 0<br>}<br>} |


#### Admin Account

```http
GET api/v1/admin/user
```


| Auth | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Auth Key` | Bearer Token | Response of token that is returned by login |

`Response`
| Status Code | Structure | Example |
| ---------- |--------- | ------ |
| 200 | { <br> data: <br> "user object" <br>} | { <br>data: { <br>id: 1, <br>name: "user-1",<br>email: "test1@test.com",<br>email_verified_at: null,<br>created_at: "2023-07-06T09:45:39.000000Z",<br>updated_at: "2023-07-06T09:45:39.000000Z",<br>is_admin: 1<br>}<br>} |



#### verification email

```http
POST api/v1/auth/email/send
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | Name of the user |
| `email` | `string` | Email id of the user  |
| `password` | `string` | password for the email handel  |
| `password_confirmation` | `string` | Retyped password |

`Response`
| Status Code | Structure                            | Example               |
| ----------- | ------------------------------------ | --------------------- |
| 200         | {<br>status: string<br>}             | {<br>status: "success"<br>} |

#### verify email

```http
GET api/v1/auth/email/verify/{id}/{identifier}
```
| Parameter   | Type     | Description            |
| :---------- | :------- | :--------------------- |
| `expires`   | `string` | Expiration timestamp   |
| `signature` | `string` | Signature for validation |

`Response`
| Status Code | Structure      | Example         |
| ----------- | ------------- | ----------------- |
| 200         | {<br>expires: string,<br>signature: string<br>}                | {<br>expires: "1688641679",<br>signature: "8cc2ea92eab079f0a71ece264389cf57f1c7ae96eb527d2939d3d36224609733"<br>} |

## Authors

- [Bhuvanesh](https://www.github.com/bhuvi100)
- [Ashwin Biju](https://www.github.com/ashwinbiju09)
- [Dhivakaran](https://www.github.com/ultralegendary)


