# wp-all-forms-api
Este é um plugin para consulta de dados de diversos formulários do ecossistema wordpress.
# Pré-requisito
- [x] Instancia do WordPress - você pode saber mais <a href="https://wordpress.org/support/article/how-to-install-wordpress/">aqui</a>
- [x] Composer - você pode saber mais <a href="https://getcomposer.org/doc/00-intro.md">aqui</a>
# Instalação
1. Clone o diretório do plug-in no `/wp-content/plugins/` diretório.
```
git clone https://github.com/claudionhangapc/wp-all-forms-api.git && cd wp-all-forms-api
```
2. Instala as dependências do projeto `composer install`
3. Ative o plugin `WP All Forms API` através da página de administração do plugin WordPress
4. Depois de ativado o plugin em sua maquina, a rota de acesso será formada pela base do site, ```https://meusite.com.br``` pela base api ```/wp-json/wp-all-forms-api/v1``` e endpoint, ex:. ```/ping```. Deste modo, a rota ```https://meusite.com.br/wp-json/wp-all-forms-api/v1/ping``` permite saber se a api esta funcionando corretamente retornando um ```{"ping": "pong"}``` como resposta.

# Plugins

A ideia é implemantar endpoints para os mais diversos plugins, contendo eles mínimo 50 000 instalações ativas. Os marcados com ```ok```  significa que ja foram implementados.
- [x] Contact Form 7
- [x] WPForms
- [x] Gravity Forms
- [x] weForms
- [ ] Elementor Form 
- [ ] Ninja Forms
- [ ] Formidable Forms
- [ ] Everest Forms
- [ ] Metform Elementor Contact Form Builder 
- [ ] Forminator
- [ ] Contact Form Plugin – Fastest Contact Form Builder Plugin for WordPress by Fluent Forms
- [ ] The Divi Contact Form Module

# Documentação

1. Introdução