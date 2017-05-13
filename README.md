# sql-query-library

Pequena lib de comandos sql para simplificar conexões com o mysql.
Opera apenas com um banco de dados e schema por vez, logo é indicada para websites simples que operem apenas uma base de dados por vez.

<h2>Download</h2>

Composer - Apenas é necessário incluir no require : "gallahaaz/sql-query-library": "dev-master"

<h2>Utilização</h2>

A conexão é simples , apenas sendo necessário configurar as seguintes constantes
<p><strong>DBHOST</strong> - Host do servidor, que pode ser local ou remoto</p>
<p><strong>DBLOGIN</strong> - Login de acesso ao servidor mysql</p>
<p><strong>DBPASSWORD</strong> - Senha de acesso ao servidor mysql
<p><strong>DBSCHEMA</strong> - Schema alvo do servidor</p>
<br/>
Após a configuração, apenas é necessário invocar use Gallahaaz\SqlQueryLibrary\Query;
<h2>Funções</h2>
