# wp-general-rest-api
Este é um plugin desenvolvido com objectivo de ajudar as pessoas a desenvolverem com mais facilidades novas APIS, atraves da interface do wordpress.
# Pré-requisito
- [x] Instancia do WordPress - você pode saber mais <a href="https://wordpress.org/support/article/how-to-install-wordpress/">aqui</a>
- [x] Composer - você pode saber mais <a href="https://getcomposer.org/doc/00-intro.md">aqui</a>
# Instalação
1. Clone o diretório do plug-in no `/wp-content/plugins/` diretório.
```
git clone https://github.com/claudionhangapc/wp-general-rest-api.git && cd wp-general-rest-api
```
2. Renomeie o arquivo `.env.exemple` para `.env` e altere o valor da `KEY`
3. Instala as dependências do projeto `composer install`
3. Ative o plugin `WP General Rest API` através da página de administração do plugin WordPress
4. Depois de ativado o plugin em sua maquina, a rota de acesso será formada pela base do site, ```https://meusite.com.br/``` pela base api ```wp-json/wp-general-rest-api/v1``` e endpoint, ex:. ```/ping```, deste modo
  rota ```https://meusite.com.br/wp-json/wp-general-rest-api/v1/ping``` permite saber se a api esta funcionando corretamente retornando um ```{"ping": "pong"}``` como resposta.
# Rotas
## End-point: ping
### Method: GET
>```
>undefined
>```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: login
### Method: POST
>```
>undefined
>```
### Body (**raw**)

```json
{
  "username": "claudio",
  "password": "12345"
}
```

### Response: 200
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3dvcmRwcmVzcyIsImlhdCI6MTY2NTgwMTM5NSwiaWQiOiIxIiwiZXhwIjoxNjY1ODAxNDU1fQ.Cy7JBTFlrq5qspBMlaBOqd4SAzcXZNWp2g9r8nW1ZME",
    "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3dvcmRwcmVzcyIsImlhdCI6MTY2NTgwMTM5NSwiaWQiOiIxIiwiZXhwIjoxNjY1ODA2MzE1fQ.k9o4ao6GNKAjglGg9wLJwEwhHpu1a9oxyUF2aCI0eBY",
    "id": "1",
    "user_email": "meusitepc@gmail.com",
    "user_nicename": "claudio",
    "user_display_name": "claudio"
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: token
### Method: GET
>```
>undefined
>```
### Body (**raw**)

```json
{
  "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3dvcmRwcmVzcyIsImlhdCI6MTY2NTgwMTM5NSwiaWQiOiIxIiwiZXhwIjoxNjY1ODA2MzE1fQ.k9o4ao6GNKAjglGg9wLJwEwhHpu1a9oxyUF2aCI0eBY"
}
```

### Response: 403
```json
{
    "code": "jwt_auth_invalid_token",
    "message": "Expired token",
    "data": {
        "status": 403
    }
}
```