# sql-query-library

Pequena lib de comandos sql para simplificar conexões com o mysql.
Opera apenas com um banco de dados e schema por vez, logo é indicada para websites simples que operem apenas uma base de dados por vez.

Download

Composer - Apenas é necessário incluir no require : "gallahaaz/sql-query-library": "dev-master"

<h2>Utilização</h2>

A conexão é simples , apenas sendo necessário configurar as seguintes constantes 
DBHOST - Host do servidor, que pode ser local ou remoto
DBLOGIN - Login de acesso ao servidor mysql
DBPASSWORD - Senha de acesso ao servidor mysql
DBSCHEMA - Schema alvo do servidor
