# wp-general-rest-api
Este é um plugin desenvolvido com objectivo de ajudar as pessoas a desenvolverem com mais facilidades novas APIS, atraves da interface do wordpress.
# Instalação
1. Clone o diretório do plug-in no `/wp-content/plugins/` diretório.
```
git clone https://github.com/claudionhangapc/wp-general-rest-api.git && cd wp-general-rest-api
```
2. Renomeie o arquivo `.env.exemple` para `.env` e altere o valor da `KEY`
3. Instala as dependendencias do projeto `composer install`
3. Ative o plugin através da tela 'Plugins' no WordPress
4. Depois de activado o plugin em sua maquina, a rota de acesso será formada pela base do site, ```https://meusite.com.br/``` pela base api ```wp-json/wp-general-rest-api/v1``` e endpoint  ex:. ```/ping```, deste modo
  rota ```https://meusite.com.br/wp-json/wp-general-rest-api/v1/ping``` permite saber se a api esta funcionando corretamente retornando um ```{"ping": "pong"}``` como resposta.
  ```