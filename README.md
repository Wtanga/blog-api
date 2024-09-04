[![codecov](https://codecov.io/github/Wtanga/blog-api/branch/feature_blog_api/graph/badge.svg?token=I29PJOWGI7)](https://codecov.io/github/Wtanga/blog-api)
![Simply the best ;)](https://img.shields.io/badge/simply-the%20best%20%3B%29-orange)

<img align="right" width="50%" src="https://laravel.com/img/logotype.min.svg" alt="">

# Функциональные требования:
## Посты:
- Список полей у сущности пост: название, описание, дата создания, дата обновления, дата удаления
- API постов должно позволять получать список и пост отдельно, создавать, редактировать и удалять посты
- При создании или редактировании поста должны валидироваться поля "Название" (минимум 5 символов, максимум 255) и "Описание" (минимум 10 символов). Эти поля не могут быть пустыми.
- При создании поста должно отправляться уведомление на мейл (условному админу), верстать сообщение не надо, достаточно просто текст
- При удалении поста, дата удаления должна быть сохранена в базе данных.
- Посты с установленной датой удаления не должны отображаться при выборке. 
- При получении списка постов, необходимо возвращать только активные посты (без комментариев). При получении конкретного поста, нужно возвращать сам пост вместе с активными комментариями.
- Получение списка постов должно иметь пагинацию
## Комментарии:
- Список полей у сущности комментарий: текст, дата создания, дата обновления, дата удаления
- API комментариев должна позволять создавать, редактировать и удалять комментарии, привязанные к конкретному посту.
- Валидация комментария: поле "Текст" не может быть пустым (минимум 1 символ, максимум 1000).
- Удаленные комментарии не должны отображаться при выборке.
# Технические требования:
## API:
- Используйте протокол Http
- Получать и отправлять данные в формате json
## База данных:
- Используйте PostgreSQL, MySQL или MariaDB по вашему выбору
## Docker:
- Приложение должно быть упаковано в Docker.
- Напишите Dockerfile и docker-compose.yml
## Тесты:
 - Приложение должно быть покрыто юнит-тестами и интеграционными тестами.
## Git:
- Выложите решение на систему контроля версий (GitLab, GitHub).
- Инит Laravel должен быть на ветке master/main, код тестового задания на отдельной ветке.

## Start
`docker-compose up -d --build`

## Seed
`docker-compose exec app php artisan migrate:fresh --seed`

## Test
`docker-compose exec app php artisan test`

# API Routes

### Posts
- **`GET|HEAD`** `/api/posts`  
  _Action:_ `posts.index`  
  _Controller:_ `PostController@index`

- **`POST`** `/api/posts`  
  _Action:_ `posts.store`  
  _Controller:_ `PostController@store`

- **`GET|HEAD`** `/api/posts/{post}`  
  _Action:_ `posts.show`  
  _Controller:_ `PostController@show`

- **`PUT|PATCH`** `/api/posts/{post}`  
  _Action:_ `posts.update`  
  _Controller:_ `PostController@update`

- **`DELETE`** `/api/posts/{post}`  
  _Action:_ `posts.destroy`  
  _Controller:_ `PostController@destroy`

### Comments
- **`POST`** `/api/posts/{post}/comments`  
  _Action:_ `posts.comments.store`  
  _Controller:_ `CommentController@store`

- **`PUT|PATCH`** `/api/posts/{post}/comments/{comment}`  
  _Action:_ `posts.comments.update`  
  _Controller:_ `CommentController@update`

- **`DELETE`** `/api/posts/{post}/comments/{comment}`  
  _Action:_ `posts.comments.destroy`  
  _Controller:_ `CommentController@destroy`
