# Projeto Indicação

## Configuração

Para executar o projeto é necessário realizar a instalação de um projeto existente Laravel, seguindo os passos abaixo:

1. Acesse o diretório do projeto e realize a instalação das dependências do composer:

        # cd projeto-indicacao/backend
	    composer install
	    composer dumpautoload -o
	
2. Crie o arquivo .env:

	    cp .env.example .env
	
3. Gere a chave da aplicação:
	
	    php artisan key:generate
	
4. Crie o banco de dados e gere as migrations e seeds:

	    php artisan migrate --seed

