# wp-forms-api
Este é um plugin para consulta de dados de diversos formulários do ecossistema wordpress.
# Pré-requisito
- [x] Instancia do WordPress - você pode saber mais <a href="https://wordpress.org/support/article/how-to-install-wordpress/">aqui</a>
- [x] Composer - você pode saber mais <a href="https://getcomposer.org/doc/00-intro.md">aqui</a>
# Instalação
1. Clone o diretório do plug-in no `/wp-content/plugins/` diretório.
```
git clone https://github.com/claudionhangapc/wp-forms-api.git && cd wp-forms-api
```
2. Renomeie o arquivo `.env.exemple` para `.env` e altere o valor da `KEY`
3. Instala as dependências do projeto `composer install`
3. Ative o plugin `WP Forms Rest API` através da página de administração do plugin WordPress
4. Depois de ativado o plugin em sua maquina, a rota de acesso será formada pela base do site, ```https://meusite.com.br/``` pela base api ```wp-json/wp-forms-rest-api/v1``` e endpoint, ex:. ```/ping```, deste modo
  rota ```https://meusite.com.br/wp-json/wp-forms-rest-api/v1/ping``` permite saber se a api esta funcionando corretamente retornando um ```{"ping": "pong"}``` como resposta.
# Rotas
### End-point: ping
#### Method: GET
```
{{baseURL}}/ping
```
#### Response: 200
```json
{
    "ping": "pong"
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: login
#### Method: POST
```
{{baseURL}}/user/login
```
#### Body (**raw**)

```json
{
  "username": "claudio",
  "password": "12345"
}
```

#### Response: 200
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
#### Response: 500
```json
{
    "code": "incorrect_password",
    "message": "<strong>Erro</strong>: A senha informada para o usuário <strong>claudio</strong> está incorreta. <a href=\"http://localhost/wordpress/minha-conta/lost-password/\">Perdeu a senha?</a>",
    "data": null
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

### End-point: token
#### Method: GET
```
{{baseURL}}/user/token
```
#### Body (**raw**)

```json
{
  "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3dvcmRwcmVzcyIsImlhdCI6MTY2NTgwMTM5NSwiaWQiOiIxIiwiZXhwIjoxNjY1ODA2MzE1fQ.k9o4ao6GNKAjglGg9wLJwEwhHpu1a9oxyUF2aCI0eBY"
}
```
#### Response: 200
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3dvcmRwcmVzcyIsImlhdCI6MTY2NTgwMTQyNSwiaWQiOiIxIiwiZXhwIjoxNjY1ODAxNDg1fQ.mCa_5fjHxad_w7Zbs9TGLTGM_cXtBSMeJb85mxISZc0",
    "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3dvcmRwcmVzcyIsImlhdCI6MTY2NTgwMTQyNSwiaWQiOiIxIiwiZXhwIjoxNjY1ODA2MzQ1fQ.C31UWfB_Mpu6t1N1GkmWuzbhCURY_18NMsBAvPqNXdA",
    "id": "1"
}
```
#### Response: 403
```json
{
    "code": "jwt_auth_invalid_token",
    "message": "Expired token",
    "data": {
        "status": 403
    }
}
```