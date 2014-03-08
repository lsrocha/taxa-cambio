# Taxa de câmbio #

API PHP para conversão monetária (Real <=> moeda).

Os valores disponíveis através dela são obtidos diretamente do site do Banco Central do Brasil, o qual é atualizado de segunda a sexta, às 13h.

[Tabela de moedas do Banco Central do Brasil](http://www4.bcb.gov.br/pec/taxas/batch/cotacaomoedas.asp?id=txtodas)

## Instalação ##

1.  Clone o projeto em sua máquina/servidor

    git clone git@github.com:LRocha94/taxa-cambio.git
    
2.  Baixe as dependências utilizando o [Composer](http://getcomposer.org "Composer - gerenciador de dependências PHP")

    composer install

3.  Importe o banco de dados: `database.sql`
4.  Preencha o arquivo de configuração: `config.php`
5.  Obtenha a cotação monetária atual

    php scripts/update.php

### Apache ###

O projeto já inclui um arquivo `.htaccess` para realizar a reescrita de URL. Nada mais é necessário.

### Nginx ###

Para servidores Nginx, é preciso inserir a regra de tratamento de URL no arquivo do virtualhost utilizado, encontrado em: `/etc/nginx/sites-available/`.

#### Instalando no diretório raíz ####

```nginx
root /srv/www/taxa-cambio/;

location / {
    try_files $uri /$uri /index.php?$args;
}
```

#### Instalando em um subdiretório ####

```nginx
location /taxa-cambio/ {
    try_files $uri /$uri /taxa-cambio/index.php?$args;
}
```

### Cron job ###

Caso deseje que o banco de dados seja atualizado diariamente, seguindo a rotina de atualizações do Banco Central, crie uma nova entrada em sua cron-table:

    0 14 * * 1-5 /usr/bin/php /srv/www/taxa-cambio/scripts/update.php

Não esqueça de alterar o endereço do script acima para que replita o caminho absoluto de sua instalação.

## Licença ##

Este projeto está disponível sob a licença [GPL V2](http://choosealicense.com/licenses/gpl-v2/)